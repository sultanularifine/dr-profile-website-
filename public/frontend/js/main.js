
document.addEventListener("DOMContentLoaded", () => {
  const root=document.documentElement;
  const themeToggle=document.getElementById("themeToggle");
  const saved=localStorage.getItem("doctorTheme");
  if(saved) root.dataset.theme=saved;
  function updateTheme(){
    if(themeToggle) themeToggle.innerHTML=root.dataset.theme==="dark" ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon-stars"></i>';
  }
  updateTheme();
  themeToggle?.addEventListener("click",()=>{
    root.dataset.theme=root.dataset.theme==="dark"?"light":"dark";
    localStorage.setItem("doctorTheme",root.dataset.theme); updateTheme();
  });

  const nav=document.getElementById("mainNav");
  const top=()=>nav?.classList.toggle("scrolled",window.scrollY>20);
  window.addEventListener("scroll",top); top();

  const back=document.getElementById("backToTop");
  window.addEventListener("scroll",()=>{if(back) back.style.display=window.scrollY>500?"grid":"none";});
  back?.addEventListener("click",()=>window.scrollTo({top:0,behavior:"smooth"}));

  document.querySelectorAll(".counter").forEach(counter=>{
    const observer=new IntersectionObserver(entries=>{
      entries.forEach(entry=>{
        if(!entry.isIntersecting||entry.target.dataset.done)return;
        entry.target.dataset.done="1";
        const target=+entry.target.dataset.target; let current=0;
        const step=Math.max(1,Math.ceil(target/70));
        const timer=setInterval(()=>{
          current=Math.min(target,current+step);
          entry.target.textContent=target===6?current+" PM":current.toLocaleString("en-US")+"+";
          if(current>=target)clearInterval(timer);
        },20);
      });
    },{threshold:.6});
    observer.observe(counter);
  });

  if(window.AOS) AOS.init({duration:750,once:true,offset:70});
  const year=document.getElementById("year"); if(year) year.textContent=new Date().getFullYear();
});
