window.onload = function(){
    window.onscroll=function(){slide();}

    var header = document.getElementById("header");

    var sticky = header.offsetTop;

    function slide(){
        if(window.pageYOffset>sticky){
            header.classList.add("sticky");
        }else{
            header.classList.remove("sticky");
        }
    }
    
}