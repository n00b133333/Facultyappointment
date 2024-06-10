<script>
    
    //Making the side navigation collapsible

let wholePage = document.getElementById('page_wrapper');
let btn = document.getElementById('nav_collapse_btn');


btn.addEventListener('click', collapse);

function collapse() {
  wholePage.classList.toggle('collapsed');
  if(wholePage.classList.contains('collapsed')){
    btn.innerHTML = "<i class='bx bxs-chevrons-right'></i>"; 
  } else {
    btn.innerHTML = "<i class='bx bxs-chevrons-left'></i>"; 
  } 
}

//Creating chart with Chart.js 
//Great tut on it by Traversy Madia: https://www.youtube.com/watch?v=sE08f4iuOhA

var myChart = document.getElementById('myChart').getContext('2d');



var completedTasksChart = new Chart(myChart, {
  type: 'bar', //bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data: {
    labels: ['Website Redesign', 'SEO tasks', 'Icons for DS', 'Logo Design', 'Hero section'],
    datasets: [{
      label: 'Completed Tasks',
      data: [
        319, 
        231,
        232,
        1101,
        432
      ],
      backgroundColor: 'DarkOrange',
    }]
  },
  options: {
    
  },
});


//Creating the dark/light mode toggle

let darkMode = localStorage.getItem('dark_mode');
var toggleBtn = document.querySelector('#theme_switch');

const enableDarkMode = () => {
  document.body.classList.add('dark_mode');
  localStorage.setItem('darkMode', 'enabled');
}

const disableDarkMode = () => {
  document.body.classList.remove('dark_mode');
  localStorage.setItem('darkMode', null);
}

toggleBtn.addEventListener('click', ()=>{
  darkMode = localStorage.getItem('darkMode');
  
  if(darkMode !== 'enabled'){
    enableDarkMode();
  } else {
    disableDarkMode();
  }
})
</script>
</body>
</html>