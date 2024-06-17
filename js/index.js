window.addEventListener("load", function(){

    setTimeout(
        function open(event){
            document.querySelector(".olha_o_pix").style.display = "flex"; 
            document.querySelector(".olha_o_pix").style.filter = "none";
        },
        1000
    )
});


document.querySelector("#close").addEventListener("click", function(){
    document.querySelector(".olha_o_pix").style.display = "none";
    document.querySelector(".olha_o_pix").style.filter = "none";
});