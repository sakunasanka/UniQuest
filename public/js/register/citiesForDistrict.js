document.addEventListener('DOMContentLoaded', function () {
    const districtSelect = document.getElementById('districtID');
    const citySelect = document.getElementById('cityID');

    const preselectedDistrictID = districtSelect.dataset.preselectedDistrict;
    const preselectedCityID = citySelect.dataset.preselectedCity;

    async function fetchCities(districtID, selectedCityID = null) {
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

            citySelect.innerHTML = '<option value="" disabled>Select City</option>';

            if (data.success && Array.isArray(data.cities)) {
                data.cities.forEach(city => {
                    const option = new Option(city.CityName, city.CityID);
                    citySelect.add(option);
                });

                if (selectedCityID) {
                    citySelect.value = selectedCityID;
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

    // Pre-load cities if district is already selected
    if (preselectedDistrictID) {
        fetchCities(preselectedDistrictID, preselectedCityID);
    }

    // On district change
    districtSelect.addEventListener('change', function () {
        citySelect.innerHTML = '<option value="" disabled selected>Select City</option>';
        if (this.value) {
            fetchCities(this.value); // don't auto-select any city on change
        }
    });
});
