(()=>{"use strict";window.addEventListener("click",(function(e){if(e.target)if(e.target.classList.contains("pgc-sgb-onclick-selection")){window.getSelection().removeAllRanges();var t=document.createRange();t.selectNodeContents(e.target),window.getSelection().addRange(t);try{document.execCommand("copy")&&(e.target.classList.add("pgc-copied"),setTimeout((function(){e.target.classList.remove("pgc-copied")}),2e3),window.getSelection().removeAllRanges())}catch(e){console.log(e)}}else if(e.target.classList.contains("pgc-close-button")){var c=document.getElementsByClassName("pgc-sgb-notic");c.length&&c[0].classList.remove("active"),localStorage.setItem("pgc-hide-posts-notic","1")}})),window.addEventListener("load",(function(){if(!localStorage.getItem("pgc-hide-posts-notic")){var e=document.getElementsByClassName("pgc-sgb-notic");e.length&&e[0].classList.add("active")}}))})();