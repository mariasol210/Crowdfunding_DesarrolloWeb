
//donation refresher
let donation_in = document.getElementById("donation_input");
let donation = document.getElementsByClassName("donativo");
for (let i = 0; i < donation.length; i++) {
    donation[i].innerHTML = 0.0;
}

//Contribution calculator and refresher
let slider = document.getElementById("contribution_input");
let output = document.getElementById("demo");
let contibution = document.getElementsByClassName("aportacion");
for (let i = 0; i < contibution.length; i++) {
    contibution[i].innerHTML = 0.0;
}
//output.innerHTML = 0 + "€ ("+slider.value + "%)";
let contribution_result = (donation_in.value*slider.value) /100
output.innerHTML = contribution_result + "€ ("+slider.value + "%)";

//total refresher
let total = document.getElementsByClassName("total");
for (let i = 0; i < total.length; i++) {
    total[i].innerHTML = 0.0;
}

donation_in.oninput = function() {
    for (let i = 0; i < donation.length; i++) {
        donation[i].innerHTML =  donation_in.value;
    }    
    contribution_result = (donation_in.value*slider.value) /100;
    output.innerHTML = contribution_result + "€ ("+slider.value + "%)";
    for (let i = 0; i < contibution.length; i++) {
        contibution[i].innerHTML =contribution_result;
    }
    for (let i = 0; i < total.length; i++) {
        total[i].innerHTML = Number(donation_in.value) + Number(contribution_result);
    }
}


slider.oninput = function() {
    contribution_result = (donation_in.value*slider.value) /100
    output.innerHTML = contribution_result + "€ ("+this.value + "%)";
    for (let i = 0; i < contibution.length; i++) {
        contibution[i].innerHTML =contribution_result;
    }
    for (let i = 0; i < total.length; i++) {
        total[i].innerHTML = Number(donation_in.value) + Number(contribution_result);
    }
}




