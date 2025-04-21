document.addEventListener('DOMContentLoaded', function() {
    const districtDropdown = document.getElementById('job_district');
    const cityDropdown = document.getElementById('job_city');

    if (!districtDropdown || !cityDropdown) {
        console.error('Required dropdown elements not found');
        return;
    }

    districtDropdown.addEventListener('change', function() {
        const districtID = this.value;
        
        // Reset city dropdown
        cityDropdown.innerHTML = '<option value="" disabled selected>Loading cities...</option>';
        cityDropdown.disabled = true;

        if (districtID) {
            fetch('/UniQuest/service_provider/getCitiesByDistrict', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'districtID=' + encodeURIComponent(districtID)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                cityDropdown.innerHTML = '<option value="" disabled selected>Select City</option>';
                
                if (data.success && Array.isArray(data.cities)) {
                    data.cities.forEach(city => {
                        const option = new Option(city.CityName, city.CityID);
                        cityDropdown.add(option);
                    });
                } else {
                    throw new Error(data.message || 'Invalid cities data');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                cityDropdown.innerHTML = '<option value="" disabled selected>Error loading cities</option>';
            })
            .finally(() => {
                cityDropdown.disabled = false;
            });
        } else {
            cityDropdown.innerHTML = '<option value="" disabled selected>Select City</option>';
            cityDropdown.disabled = false;
        }
    });

    // Initialize if district is already selected
    if (districtDropdown.value) {
        districtDropdown.dispatchEvent(new Event('change'));
    }
});