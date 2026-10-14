<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PageContentController extends Controller
{
    /** The full legacy defaults stay available for frontend fallbacks. */
    private function allDefaults(): array
    {
        return config('page_content_defaults', []);
    }

    /** Current, live template keys in source order; stale generated entries are not shown. */
    private function defaults(): array
    {
        $all = $this->allDefaults();
        $activeKeys = config('page_content_active_keys', array_keys($all));
        $active = [];

        foreach ($activeKeys as $key) {
            if (array_key_exists($key, $all)) {
                $active[$key] = $all[$key];
            }
        }

        return $active;
    }

    private function labelFor(string $key, string $default): string
    {
        if (str_ends_with($key, 'doctor_image_alt')) {
            return 'Doctor image alt text';
        }
        if (str_ends_with($key, 'doctor_image')) {
            return 'Doctor profile image';
        }
        if ($this->isImageKey($key)) {
            $ending = strtolower((string) Str::afterLast($key, '.'));
            return Str::headline($ending);
        }

        $plain = html_entity_decode(strip_tags($default), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $plain = preg_replace('/\s+/u', ' ', trim($plain)) ?? trim($plain);

        return $plain !== '' ? Str::limit($plain, 86) : 'Text field ' . $key;
    }

    private function sectionMetaFor(string $key): array
    {
        return config('page_content_sections.' . $key, [
            'group_id' => 'additional:' . Str::before($key, '.'),
            'section_label' => 'Additional page content',
        ]);
    }

    private function isImageKey(string $key): bool
    {
        return (bool) preg_match('/(^|\.)([a-z0-9_-]*image|[a-z0-9_-]*photo|logo)$/i', $key);
    }

    public function index(Request $request)
    {
        $defaults = $this->defaults();
        $allDefaults = $this->allDefaults();
        $overrides = PageContent::query()->get()->keyBy('content_key');
        $page = $request->query('page_name', 'all');
        $search = trim((string) $request->query('q', ''));

        $items = collect($defaults)->map(function (array $item, string $key) use ($overrides) {
            $row = $overrides->get($key);
            $default = (string) ($item['default'] ?? '');

            return [
                'content_key' => $key,
                'page' => $item['page'] ?? 'custom',
                'label' => $this->labelFor($key, $default),
                'default' => $default,
                'value' => $row?->value,
                'is_custom' => $row && $row->value !== null && $row->value !== '',
                'is_image' => $this->isImageKey($key),
            ];
        });

        // Add custom fields created by an administrator. Old, unused generated keys are left in the DB but hidden.
        foreach ($overrides as $key => $row) {
            if (!isset($allDefaults[$key])) {
                $items->push([
                    'content_key' => $key,
                    'page' => $row->page,
                    'label' => $this->labelFor($key, (string) $row->value),
                    'default' => '',
                    'value' => $row->value,
                    'is_custom' => true,
                    'is_image' => $this->isImageKey($key),
                ]);
            }
        }

        if ($page !== 'all') {
            $items = $items->where('page', $page);
        }
        if ($search !== '') {
            $needle = Str::lower($search);
            $items = $items->filter(fn (array $item) => Str::contains(
                Str::lower($item['content_key'] . ' ' . $item['label'] . ' ' . $item['default'] . ' ' . ($item['value'] ?? '')),
                $needle
            ));
        }

        $items = $items->values();
        $perPage = 30;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginator = new LengthAwarePaginator(
            $items->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $items->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        $pages = collect($defaults)->pluck('page')->filter()->unique()->values();

        return view('backend.page-content.index', compact('paginator', 'pages', 'page', 'search'));
    }

    public function page(string $page)
    {
        $pageDefaults = collect($this->defaults())->filter(fn (array $item) => ($item['page'] ?? '') === $page);
        abort_if($pageDefaults->isEmpty(), 404);

        $overrides = PageContent::query()->where('page', $page)->get()->keyBy('content_key');
        $items = $pageDefaults->map(function (array $item, string $key) use ($overrides) {
            $row = $overrides->get($key);
            $default = (string) ($item['default'] ?? '');
            $section = $this->sectionMetaFor($key);

            return [
                'content_key' => $key,
                'label' => $this->labelFor($key, $default),
                'section_id' => $section['group_id'] ?? 'additional:' . $key,
                'section_label' => $section['section_label'] ?? 'Additional page content',
                'default' => $default,
                'value' => $row?->value,
                'is_custom' => $row && $row->value !== null && $row->value !== '',
                'is_image' => $this->isImageKey($key),
            ];
        })->values();

        $groups = $items->groupBy('section_id')->map(function ($group, $groupId) {
            return [
                'id' => Str::slug($groupId),
                'label' => $group->first()['section_label'],
                'items' => $group->values(),
            ];
        })->values();

        return view('backend.page-content.page', compact('page', 'items', 'groups'));
    }

    public function updatePage(Request $request, string $page)
    {
        $pageDefaults = collect($this->defaults())->filter(fn (array $item) => ($item['page'] ?? '') === $page);
        abort_if($pageDefaults->isEmpty(), 404);

        $request->validate([
            'content' => ['nullable', 'array'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'reset_image' => ['nullable', 'array'],
            'reset_image.*' => ['nullable', 'boolean'],
        ]);
        $contentInput = $request->input('content', []);

        foreach ($pageDefaults as $key => $item) {
            $slug = str_replace(['.', '-'], '_', $key);
            $existing = PageContent::query()->where('content_key', $key)->first();
            $oldValue = $existing?->value;
            $hasTextField = is_array($contentInput) && array_key_exists($key, $contentInput);
            $value = $hasTextField ? $contentInput[$key] : null;
            if ($hasTextField) {
                $checked = Validator::make(['value' => $value], ['value' => ['nullable', 'string', 'max:50000']])->validate();
                $value = $checked['value'] ?? null;
            }
            $image = $this->isImageKey($key) ? $request->file('images.' . $slug) : null;
            $resetImage = $request->boolean('reset_image.' . $slug);

            if ($image) {
                $directory = public_path('uploads/page-content');
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }
                $filename = Str::uuid()->toString() . '.' . $image->extension();
                $image->move($directory, $filename);
                $value = 'uploads/page-content/' . $filename;
                $this->deleteManagedPageImage($oldValue);
            } elseif ($resetImage && $this->isImageKey($key)) {
                $value = null;
                $this->deleteManagedPageImage($oldValue);
            } elseif (!$hasTextField && $existing) {
                // Missing keys should not reset stored data; image-only fields have no text input.
                continue;
            } elseif (!$hasTextField && !$existing && !$this->isImageKey($key)) {
                // Missing text fields in a partial request should not create empty overrides.
                continue;
            }

            PageContent::updateOrCreate(
                ['content_key' => $key],
                ['page' => $page, 'value' => ($value === '' ? null : $value)]
            );
        }

        Cache::forget('page_content_overrides');

        return redirect()->route('admin.pages.edit', $page)->with(
            'success',
            ucfirst(str_replace(['-', '_'], ' ', $page)) . ' page saved. Empty text fields restore their original text.'
        );
    }

    private function deleteManagedPageImage(?string $path): void
    {
        if (!$path || !str_starts_with($path, 'uploads/page-content/')) {
            return;
        }

        $filename = basename($path);
        if ($filename === '' || in_array($filename, ['.', '..'], true)) {
            return;
        }

        $fullPath = public_path('uploads/page-content/' . $filename);
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    public function create()
    {
        $pages = collect($this->defaults())->pluck('page')->filter()->unique()->values();
        return view('backend.page-content.create', compact('pages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content_key' => ['required', 'string', 'max:190', 'regex:/^[a-zA-Z0-9_.-]+$/', 'unique:page_contents,content_key'],
            'page' => ['required', 'string', 'max:80'],
            'value' => ['nullable', 'string', 'max:50000'],
        ]);

        PageContent::create($data);
        Cache::forget('page_content_overrides');

        return redirect()->route('admin.page-content.index')->with('success', 'Content field created. It will appear wherever the key is used by a template.');
    }

    public function edit(string $key)
    {
        $defaults = $this->allDefaults();
        $row = PageContent::query()->where('content_key', $key)->first();
        abort_unless(isset($defaults[$key]) || $row, 404);

        $item = [
            'content_key' => $key,
            'page' => $defaults[$key]['page'] ?? $row->page,
            'label' => $this->labelFor($key, (string) ($defaults[$key]['default'] ?? $row?->value ?? '')),
            'default' => $defaults[$key]['default'] ?? '',
            'value' => $row?->value,
        ];

        return view('backend.page-content.edit', compact('item'));
    }

    public function update(Request $request, string $key)
    {
        $defaults = $this->allDefaults();
        $row = PageContent::query()->where('content_key', $key)->first();
        abort_unless(isset($defaults[$key]) || $row, 404);

        $data = $request->validate(['value' => ['nullable', 'string', 'max:50000']]);
        PageContent::updateOrCreate(
            ['content_key' => $key],
            [
                'page' => $defaults[$key]['page'] ?? $row?->page ?? 'custom',
                'value' => $data['value'] ?? null,
            ]
        );
        Cache::forget('page_content_overrides');

        return redirect()->route('admin.page-content.index')->with('success', 'Content updated.');
    }

    public function destroy(string $key)
    {
        PageContent::query()->where('content_key', $key)->delete();
        Cache::forget('page_content_overrides');

        return redirect()->route('admin.page-content.index')->with('success', 'Override removed. The original default text is active again.');
    }
}
