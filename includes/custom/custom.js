// JavaScript Document
$(document).ready(function(e) {
    const modeButton = document.getElementById('darkModeToggle');
    const body = document.body;
    if(modeButton){
        // Check localStorage for dark mode setting
        if (localStorage.getItem('darkMode') === 'enabled') {
            body.classList.add('dark-mode');
            modeButton.innerHTML='<i class="fas fa-sun"></i>';
        }
        else{
            modeButton.innerHTML='<i class="fas fa-moon"></i>';
        }

        // Toggle dark mode on button click
        modeButton.addEventListener('click', () => {
            if (body.classList.contains('dark-mode')) {
                body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', 'disabled');
                modeButton.innerHTML='<i class="fas fa-moon"></i>';
            } else {
                body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'enabled');
                modeButton.innerHTML='<i class="fas fa-sun"></i>';
            }
        });
    }
	if($('.toastr-notify').length){
		$this=$('.toastr-notify');
		toastr.options={
		  "closeButton": true,
		  "positionClass": $this.data('position'),
		  "timeOut": "5000"
		};
		toastr[$this.data('status')]($this.html(), $this.data('title'));
    }
	if($('.tom-select').length){
        $('.tom-select').each(function(index,ele){
            createTomSelect(ele)
        });
    }
});

function createTomSelect(ele){
    $(ele).removeClass('form-control');
    new TomSelect(ele, {
    create: false,
    maxItems: 1,     // only one item
    allowEmptyOption: true,
    plugins: []      // no tagging, no remove buttons
  });
}

// Simple show/hide functions
function showLoader() {
  document.getElementById('loader-overlay').style.display = 'flex';
}
function hideLoader() {
  document.getElementById('loader-overlay').style.display = 'none';
}

function getLocation(loader=false){
    if (!navigator.geolocation) {
        hideLoader();
        alert("Geolocation is not supported by your browser.");
        return;
    }
    if(loader){
        showLoader();
    }
    navigator.geolocation.getCurrentPosition(
        (pos) => {
            const lat = pos.coords.latitude.toFixed(6);
            const lng = pos.coords.longitude.toFixed(6);

            // Fill form inputs
            document.getElementById('emp-latitude').value = lat;
            document.getElementById('emp-longitude').value = lng;
            hideLoader();
            saveLocation();
        },
        (err) => {
            alert("Unable to retrieve your location. Error: " + err.message);
        },
        { enableHighAccuracy: true }
    );
}
