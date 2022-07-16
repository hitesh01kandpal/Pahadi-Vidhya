const body = document.querySelector('body'),
  sidebar = body.querySelector('nav'),
  toggle = body.querySelector(".toggle"),
  modeSwitch = body.querySelector(".toggle-switch"),
  modeText = body.querySelector(".mode-text");


toggle.addEventListener("click", () => {
  sidebar.classList.toggle("close");
})

modeSwitch.addEventListener("click", setTheme );

function setTheme(){
  isSet=body.classList.contains("dark");
  body.classList.toggle("dark");
  if (body.classList.contains("dark")) {
    modeText.innerText = "Light mode";
  } else {
    modeText.innerText = "Dark mode";
  }
  jQuery.ajax({
    url:'../includes/set_theme.php',
    type: 'POST',
    data: {
      'checked' : isSet ? 'light' : 'dark'
    },
    success:function(){
    }
  });
}

function setDarkTheme(){
  body.classList.toggle("dark");
  modeText.innerText = "Dark mode";
}

function updateUserStatus(){
  jQuery.ajax({
    url:'../includes/update_user_status.php',
    success:function(){
    }
  });

}

function getUserData(){
  jQuery.ajax({
    url:'../includes/getUserData.php',
    success:function(result){
        jQuery("#userData").html(result)
    }
  });

}

setInterval(function(){
  getUserData();
 
},4000);

 setInterval(function(){
   updateUserStatus();
  
 },2000);
