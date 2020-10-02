window.onload = function(){
    initialize();
}

function initialize(){
    let max = document.getElementById("stk").value;
    if(max<=0){
        let element = document.getElementById("num-btn");
        element.setAttribute("disabled","true");
        element = document.getElementsByClassName("change-btn");
        for(let x=0;x<element.length;x++){
            element[x].setAttribute("onclick","button_disabled()");
        }
        element.value=0;
    }else{
        let element = document.getElementById("num-btn");
        element.value=1;
    }
}

function add1(){
    let max = document.getElementById("stk").value;
    let element = document.getElementById("num-btn");
    if(element.value>=max){
        alert("The value already reached maximum value!");
        element.value=max;
    }else{
        element.value++;
    }
}

function minus1(){
    let min=0;
    let element = document.getElementById("num-btn");
    if(element.value<=min){
        alert("The value already reached minimum value!");
    }else{
        element.value--;
    }
}

function button_disabled(){
    alert("No more tickets for the bus!");
}

function check_value(){
    if(this.value=="")
        this.value = 0;
    
    if(parseInt(this.value)>max){
        alert(`Invalid value, the number entered should less than ${max}`);
        this.value=8;
    }
    
    if(parseInt(this.value)<min){
        alert("Invalid value, the number entered should more than 0");
        this.value=0;
    }
}
