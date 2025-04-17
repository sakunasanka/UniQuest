// This script handles the dynamic loading of cities based on the selected district.
document.addEventListener('DOMContentLoaded', function() {
    const districtSelect = document.querySelector('select[name="district"]');
    const citySelect = document.querySelector('select[name="city"]');
    
    // Function to get URL query parameter
    function getQueryParam(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // Function to fetch cities
    async function fetchCities(districtID, selectCity = null) {
        citySelect.disabled = true;
        // citySelect.innerHTML = '<option value="">Loading cities...</option>';

        try {
            const response = await fetch('/UniQuest/jobs/getCitiesByDistrict', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'districtID=' + encodeURIComponent(districtID)
            });

            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();

            citySelect.innerHTML = '<option value="">All Cities</option>';

            if (data.success && Array.isArray(data.cities) && data.cities.length) {
                data.cities.forEach(city => {
                    const option = new Option(city.CityName, city.CityName);
                    citySelect.add(option);
                });

                // Select city from query params if exists
                if (selectCity) {
                    const cityParam = getQueryParam('city');
                    if (cityParam) {
                        Array.from(citySelect.options).forEach(option => {
                            if (option.value === cityParam) {
                                option.selected = true;
                            }
                        });
                    }
                }
            } else {
                citySelect.innerHTML = '<option value="">No cities available</option>';
            }
        } catch (error) {
            console.error('Error fetching cities:', error);
            citySelect.innerHTML = '<option value="">Error loading cities</option>';
        } finally {
            citySelect.disabled = false;
        }
    }

    // Get city from URL params
    const cityParam = getQueryParam('city');

    // Handle initial load
    const initiallySelectedDistrict = districtSelect.options[districtSelect.selectedIndex];
    if (initiallySelectedDistrict && initiallySelectedDistrict.id) {
        fetchCities(initiallySelectedDistrict.id, true);
    }

    // Handle district changes
    districtSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        citySelect.innerHTML = '<option value="">All Cities</option>';
        
        if (selectedOption.id) {
            fetchCities(selectedOption.id);
        }
    });

    // If city param exists but no district is selected, try to find matching district
    if (cityParam && (!initiallySelectedDistrict || !initiallySelectedDistrict.id)) {
        // This would require additional logic to map city to district
        // You might need an API endpoint to get district by city
        console.log('City parameter found but no district selected');
    }
});
