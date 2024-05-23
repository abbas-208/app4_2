/* -- collapsible css -- */

var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active-section");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      let h = content.scrollHeight + 80;
      content.style.maxHeight = h + "px";
      content.style.height = h + "px";
    }
  });
}

document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll('#admin-sidebar .nav-link').forEach(function(element){

    element.addEventListener('click', function (e) {

        let nextEl = element.nextElementSibling;
        let parentEl  = element.parentElement;

        if(nextEl) {
            e.preventDefault();
            let mycollapse = new bootstrap.Collapse(nextEl);

            if(nextEl.classList.contains('show')){
                mycollapse.hide();
            } else {
                mycollapse.show();
                // find other submenus with class=show
                var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                // if it exists, then close all of them
                if(opened_submenu){
                    new bootstrap.Collapse(opened_submenu);
                }
            }
        }
    }); // addEventListener
    }) // forEach
});
