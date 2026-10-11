
document.addEventListener("DOMContentLoaded", () => {
  const data = [
    ["General","পেটব্যথা"],["General","খাওয়ায় অরুচি ও বদহজম"],["General","পেট ফেঁপে যাওয়া"],["General","খাদ্যনালীর সমস্যা"],["General","ওজন না বাড়া, দুর্বলতা"],["General","জন্ডিস না সারা"],["General","বুকে পানি জমা ও শ্বাসকষ্ট"],["General","গলা ব্যথা ও ফোলা"],["General","নাকের পলিপ"],
    ["Surgery","হার্নিয়া ও হাইড্রোসিল"],["Surgery","পিত্তথলিতে পাথর"],["Surgery","অ্যাপেন্ডিসাইটিস"],["Surgery","পেটের নাড়ি পেঁচিয়ে যাওয়া"],["Surgery","মলদ্বারের পাইলস, ফিসার ও ফিস্টুলা"],["Surgery","ব্রেস্ট ডিজিজ"],["Surgery","পায়খানার রাস্তায় ব্যথা ও রক্তপাত"],["Surgery","নাভির সমস্যা"],["Surgery","প্লাস্টিক সার্জারি"],
    ["Urology","কিডনিতে পানি জমা"],["Urology","অণ্ডকোষে ব্যথা ও ফোলা"],["Urology","ইউরোলজিক্যাল সমস্যা"],["Urology","তৃতীয় লিঙ্গের (হিজড়া) সমস্যা"],["Urology","কিডনিতে পাথর ও ইনফেকশন"],["Urology","প্রস্রাবের রাস্তা সঠিক স্থানে না থাকা"],["Urology","সুন্নতে খৎনা করা হয়"],["Urology","মূত্রত্যাগে প্রদাহ ও ঘন ঘন প্রস্রাব হওয়া"],
    ["Congenital","অণ্ডকোষ সঠিক স্থানে না থাকা"],["Congenital","জন্মগত পা বাঁকা"],["Congenital","ঠোঁট ও তালু কাটা"],["Congenital","জন্মগত ত্রুটি"],["Congenital","পায়খানার রাস্তা সঠিক স্থানে না থাকা"],
    ["Neonatal","নবজাতক সার্জারি"],
    ["Plastic Surgery","শিশু বার্ন ও প্লাস্টিক সার্জারি"],["Plastic Surgery","বার্ন ম্যানেজমেন্ট"],
    ["Neurosurgery","শিশু নিউরোসার্জারি"],["Neurosurgery","মাথায় পানি জমা ও ফোলা"],["Neurosurgery","মেরুদণ্ডের টিউমার"],["Neurosurgery","নিউরোসার্জিক্যাল সমস্যা"],
    ["Oncology","শিশু ক্যান্সার সার্জারি"],["Oncology","শরীরের যেকোনো স্থানের টিউমার"],["Oncology","লিভার, কিডনি, খাদ্যনালী ও পেটের ক্যান্সার"],["Oncology","প্লীহা বড় হওয়া (থ্যালাসেমিয়া)"],
    ["Hepato-Biliary","হেপাটো-বিলিয়ারি সার্জারি"],
    ["Orthopedics","অর্থোপেডিক্স"],["Orthopedics","জন্মগত পা বাঁকা"],["Orthopedics","হাত ও পায়ের সমস্যা"]
  ];
  const labels={All:"সব",General:"সাধারণ",Surgery:"সার্জারি",Urology:"ইউরোলজি",Congenital:"জন্মগত",Neonatal:"নবজাতক", "Plastic Surgery":"বার্ন ও প্লাস্টিক","Neurosurgery":"নিউরোসার্জারি",Oncology:"অনকোলজি","Hepato-Biliary":"হেপাটো-বিলিয়ারি",Orthopedics:"অর্থোপেডিক্স"};
  const fw=document.getElementById("conditionFilters"), grid=document.getElementById("conditionGrid");
  if(!fw||!grid) return;
  const filters=["All",...new Set(data.map(x=>x[0]))];
  fw.innerHTML=filters.map((f,i)=>`<button class="filter-btn ${i===0?"active":""}" data-filter="${f}">${labels[f]||f}</button>`).join("");
  function render(f="All"){
    const list=f==="All"?data:data.filter(x=>x[0]===f);
    grid.innerHTML=list.map(x=>`<div class="col-sm-6 col-lg-4"><div class="condition-card"><span class="condition-dot"></span><span>${x[1]}</span></div></div>`).join("");
  }
  render();
  fw.querySelectorAll(".filter-btn").forEach(b=>b.addEventListener("click",()=>{
    fw.querySelectorAll(".filter-btn").forEach(x=>x.classList.remove("active"));
    b.classList.add("active"); render(b.dataset.filter);
  }));
});
