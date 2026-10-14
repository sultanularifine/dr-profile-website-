@extends('backend.layouts.app')

@section('title', 'Payment Settings')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Payment Settings <small class="text-muted d-block mt-1" style="font-size:13px">অনলাইন গেটওয়ে ও ম্যানুয়াল পেমেন্ট</small></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active">Payment Settings</div>
            </div>
        </div>
        <div class="section-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('warning'))<div class="alert alert-warning">{{ session('warning') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger"><strong>Please correct these settings:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header"><h4><i class="fas fa-shield-alt mr-2"></i>SSLCommerz Gateway Credentials</h4></div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.payment-settings.update') }}">
                                @csrf @method('PUT')
                                <div class="form-group">
                                    <label for="sslcommerz_enabled">Enable SSLCommerz online payment</label>
                                    <input type="hidden" name="sslcommerz_enabled" value="0">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="sslcommerz_enabled" name="sslcommerz_enabled" value="1" @checked(old('sslcommerz_enabled', $enabled ? '1' : '0') == '1')>
                                        <label class="custom-control-label" for="sslcommerz_enabled">Allow patients to pay appointment fees online</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sslcommerz_environment">Environment</label>
                                    <select class="form-control" id="sslcommerz_environment" name="sslcommerz_environment" required>
                                        <option value="sandbox" @selected(old('sslcommerz_environment', $environment) === 'sandbox')>Sandbox (test payments)</option>
                                        <option value="live" @selected(old('sslcommerz_environment', $environment) === 'live')>Live (real payments)</option>
                                    </select>
                                    <small class="form-text text-muted">Use Sandbox first. Live mode can charge real money.</small>
                                </div>
                                <div class="form-group">
                                    <label for="sslcommerz_store_id">Store ID</label>
                                    <input class="form-control" id="sslcommerz_store_id" name="sslcommerz_store_id" value="{{ old('sslcommerz_store_id', $storeId) }}" maxlength="100" autocomplete="off">
                                    <small class="form-text text-muted">Paste the Store ID issued for the selected environment.</small>
                                </div>
                                <div class="form-group">
                                    <label for="sslcommerz_store_passwd">Store Password</label>
                                    <input type="password" class="form-control" id="sslcommerz_store_passwd" name="sslcommerz_store_passwd" autocomplete="new-password" placeholder="{{ $passwordConfigured ? 'Saved securely — leave blank to keep current password' : 'Enter the Store Password' }}">
                                    <small class="form-text {{ $passwordConfigured ? 'text-success' : 'text-warning' }}">{{ $passwordConfigured ? 'A password is saved in encrypted form.' : 'No Store Password has been saved yet.' }}</small>
                                    @if($passwordConfigured)
                                        <div class="custom-control custom-checkbox mt-2"><input type="checkbox" class="custom-control-input" id="clear_store_password" name="clear_store_password" value="1"><label class="custom-control-label" for="clear_store_password">Remove saved password</label></div>
                                    @endif
                                </div>
                                <hr class="my-4">
                                <div class="payment-setting-section mb-4">
                                    <h4><i class="fas fa-mobile-alt mr-2 text-primary"></i>ম্যানুয়াল bKash / Nagad পেমেন্ট</h4>
                                    <p class="text-muted">এখানে আপনার টাকা গ্রহণের নম্বর দিন। চালু করলে রোগীর Payment পেজে নম্বর দেখা যাবে। রোগী টাকা পাঠিয়ে TrxID দেবে; আপনি নম্বর/TrxID মিলিয়ে পেমেন্ট Verify করলে Appointment-এর Payment Status “Paid” হবে।</p>
                                    <div class="form-group">
                                        <input type="hidden" name="manual_payment_enabled" value="0">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="manual_payment_enabled" name="manual_payment_enabled" value="1" @checked(old('manual_payment_enabled', $manualSettings['manual_payment_enabled'] ?? '0') == '1')>
                                            <label class="custom-control-label" for="manual_payment_enabled">রোগীদের জন্য Manual Payment চালু</label>
                                        </div>
                                        <small class="form-text text-muted">বন্ধ করলে রোগীরা নতুন bKash/Nagad/Bank payment submission দিতে পারবে না। আগের payment history থাকবে।</small>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="bkash_payment_number">bKash নম্বর</label>
                                            <input class="form-control" type="text" inputmode="tel" id="bkash_payment_number" name="bkash_payment_number" maxlength="80" value="{{ old('bkash_payment_number', $manualSettings['bkash_payment_number'] ?? '') }}" placeholder="01XXXXXXXXX">
                                            <small class="form-text text-muted">খালি রাখলে রোগীর পেজে bKash অপশন দেখাবে না।</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nagad_payment_number">Nagad নম্বর</label>
                                            <input class="form-control" type="text" inputmode="tel" id="nagad_payment_number" name="nagad_payment_number" maxlength="80" value="{{ old('nagad_payment_number', $manualSettings['nagad_payment_number'] ?? '') }}" placeholder="01XXXXXXXXX">
                                            <small class="form-text text-muted">খালি রাখলে রোগীর পেজে Nagad অপশন দেখাবে না।</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_instructions">রোগীর জন্য পেমেন্ট নির্দেশনা</label>
                                        <textarea class="form-control" id="payment_instructions" name="payment_instructions" rows="3" maxlength="2000" placeholder="যেমন: Send Money করুন, সঠিক পরিমাণ পাঠান, তারপর TrxID দিন।">{{ old('payment_instructions', $manualSettings['payment_instructions'] ?? '') }}</textarea>
                                    </div>
                                    <details class="mb-3">
                                        <summary class="font-weight-bold">ঐচ্ছিক: Bank Transfer তথ্য</summary>
                                        <div class="row mt-3">
                                            <div class="form-group col-md-4"><label for="bank_name">Bank Name</label><input class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name', $manualSettings['bank_name'] ?? '') }}" maxlength="255"></div>
                                            <div class="form-group col-md-4"><label for="bank_account_name">Account Name</label><input class="form-control" id="bank_account_name" name="bank_account_name" value="{{ old('bank_account_name', $manualSettings['bank_account_name'] ?? '') }}" maxlength="255"></div>
                                            <div class="form-group col-md-4"><label for="bank_account_number">Account Number</label><input class="form-control" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $manualSettings['bank_account_number'] ?? '') }}" maxlength="120"></div>
                                        </div>
                                    </details>
                                    <div class="alert alert-info mb-0"><strong>নিরাপত্তা:</strong> TrxID শুধু দেখে নিশ্চিত না হয়ে নিজের bKash/Nagad অ্যাকাউন্টে আসা লেনদেনও মিলিয়ে নিন। Manual Verify করলে সিস্টেম শুধু আপনার দেওয়া সিদ্ধান্ত অনুযায়ী Paid করবে; এটি provider API দিয়ে স্বয়ংক্রিয় যাচাই নয়।</div>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> সব Payment Settings সংরক্ষণ করুন</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header"><h4>Configuration status</h4></div>
                        <div class="card-body">
                            <p><strong>Gateway:</strong> <span class="badge {{ $enabled ? 'badge-success' : 'badge-secondary' }}">{{ $enabled ? 'Enabled' : 'Disabled' }}</span></p>
                            <p><strong>Environment:</strong> {{ strtoupper($environment) }}</p>
                            <p><strong>Store ID:</strong> <span class="badge {{ $storeIdConfigured ? 'badge-success' : 'badge-warning' }}">{{ $storeIdConfigured ? 'Configured' : 'Missing' }}</span></p>
                            <p><strong>Store Password:</strong> <span class="badge {{ $passwordConfigured ? 'badge-success' : 'badge-warning' }}">{{ $passwordConfigured ? 'Configured' : 'Missing' }}</span></p>
                            <hr>
                            <p><strong>Manual payments:</strong> <span class="badge {{ (($manualSettings['manual_payment_enabled'] ?? '0') === '1') ? 'badge-success' : 'badge-secondary' }}">{{ (($manualSettings['manual_payment_enabled'] ?? '0') === '1') ? 'চালু' : 'বন্ধ' }}</span></p>
                            <p><strong>bKash:</strong> {{ !empty($manualSettings['bkash_payment_number']) ? 'নম্বর দেওয়া আছে' : 'নম্বর দেওয়া হয়নি' }}</p>
                            <p><strong>Nagad:</strong> {{ !empty($manualSettings['nagad_payment_number']) ? 'নম্বর দেওয়া আছে' : 'নম্বর দেওয়া হয়নি' }}</p>
                            @if(!$enabled || !$storeIdConfigured || !$passwordConfigured)
                                <div class="alert alert-warning mb-0">Patients cannot start SSLCommerz checkout until the gateway is enabled and both credentials are saved.</div>
                            @else
                                <div class="alert alert-success mb-0">Required settings are present. This does not prove the credentials are accepted by SSLCommerz; run a sandbox transaction to test them.</div>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header"><h4>Sandbox checklist</h4></div>
                        <div class="card-body">
                            <ol class="pl-3 mb-0">
                                <li>Use the Sandbox Store ID and Store Password from your merchant account.</li>
                                <li>Select <strong>Sandbox</strong>, enter both values, and save.</li>
                                <li>Enable payments and save again.</li>
                                <li>Test with an appointment fee and verify the gateway result.</li>
                            </ol>
                            <a href="https://sandbox-gw.sslcommerz.com/" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-block mt-3">Open SSLCommerz Sandbox</a>
                            <p class="small text-muted mt-3 mb-0">Keep the Store Password private. Do not paste real credentials into support chats, screenshots, or source code.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
