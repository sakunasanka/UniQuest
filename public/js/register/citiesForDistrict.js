document.addEventListener('DOMContentLoaded', function() {
    const districtSelect = document.getElementById('districtID');
    const citySelect = document.getElementById('cityID');

    function getQueryParam(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    async function fetchCities(districtID, selectCity = null) {
        citySelect.disabled = true;

        try {
            const response = await fetch('/UniQuest/register/getCitiesByDistrict', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'districtID=' + encodeURIComponent(districtID)
            });

            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();

            citySelect.innerHTML = '<option value="" disabled selected>Select City</option>';

            if (data.success && Array.isArray(data.cities) && data.cities.length) {
                data.cities.forEach(city => {
                    const option = new Option(city.CityName, city.CityID);
                    citySelect.add(option);
                });

                // If cityID is in URL, pre-select it
                if (selectCity) {
                    const cityParam = getQueryParam('cityID');
                    if (cityParam) {
                        citySelect.value = cityParam;
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

    const districtParam = getQueryParam('districtID');
    const cityParam = getQueryParam('cityID');

    // Load cities if district is pre-selected
    if (districtSelect.value) {
        fetchCities(districtSelect.value, true);
    }

    // Handle district changes
    districtSelect.addEventListener('change', function() {
        citySelect.innerHTML = '<option value="" disabled selected>Select City</option>';
        if (this.value) {
            fetchCities(this.value);
        }
    });

    // Optional: fetch cities if only cityID is present, but no district selected
    if (cityParam && !districtSelect.value) {
        console.log('CityID exists in query params, but no district is selected.');
        // You could call an endpoint like `/getDistrictByCity` if needed
    }
});
