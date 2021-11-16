var nextBtn = document.getElementById('next-btn');
var newBtn = document.getElementById('new-btn');
var tabList = document.querySelector("#progress-tabs li");
var activeTab = document.querySelector("#progress-tabs li.active");
var nextTab = document.querySelector("li.active + li");
var firstTab = document.querySelector("#progress-tabs li:first-of-type");
var lastTab = document.querySelector("#progress-tabs li:last-of-type");

function upDate() {
 activeTab = document.querySelector("#progress-tabs li.active");
 nextTab = document.querySelector("li.active + li");
}

nextBtn.addEventListener("click", function(){
 if (lastTab.className === "active") {
   firstTab.className = "active";
   lastTab.className -= "active";
 } else {
  activeTab.className -= "active"; 
  nextTab.className = "active";
 }
 upDate();
 console.log('click');
});