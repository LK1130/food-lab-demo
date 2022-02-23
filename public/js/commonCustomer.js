let marquee = document.querySelector("marquee"),
    importantnews = document.querySelectorAll(".importantnews");
let navbuttons = document.querySelector(".nav-buttons");

let importantNew = function() {
    if (importantnews.length != 0) {
        for (let i = 0; i < importantnews.length; i++) {
            let category = importantnews[i].getAttribute("id");
            switch (category) {
                case "1":
                    importantnews[i].classList.add("bg-success", "text-white");
                    break;
                case "2":
                    importantnews[i].classList.add("bg-danger", "text-white");
                    break;
                case "3":
                    importantnews[i].classList.add("bg-primary", "text-white");
                    break;
                case "4":
                    importantnews[i].classList.add("bg-danger", "text-white");
                    break;
                case "5":
                    importantnews[i].classList.add("bg-warning", "text-dark");
                    break;
            }
        }
    } else {
        marquee.style.display = "none";
    }
};

importantNew();


navbuttons.addEventListener("click", function() {
    navbuttons.classList.toggle("changes");
});

window.addEventListener('load',function(){
    
})
$(document).ready(function () {

  show();
});

function show(){
    
   if(sessionStorage.clickcount > 0){
    $('.cartcount').text(sessionStorage.clickcount);
   }
}