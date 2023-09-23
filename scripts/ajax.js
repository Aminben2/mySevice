// JavaScript function to fetch services based on selected category
function getServices() {
    var categoryId = document.getElementById('categorySelect').value;
    var serviceSelect = document.getElementById('serviceSelect');
    var subServiceSelect = document.getElementById('subServiceSelect');

    // Reset service and sub-service dropdowns
    serviceSelect.innerHTML = '<option value="">Select Service</option>';
    subServiceSelect.innerHTML = '<option value="">Select Sub-Service</option>';

    // Make an AJAX request to fetch services
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_data/get_services.php?category_id=' + categoryId, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var services = JSON.parse(xhr.responseText);

            // Populate the service dropdown
            services.forEach(function (service) {
                var option = document.createElement('option');
                option.value = service.id_service;
                option.textContent = service.name_service;
                serviceSelect.appendChild(option);
            });
        }
    };
    xhr.send();
}

// JavaScript function to fetch sub-services based on selected service
function getSubServices() {
    var serviceId = document.getElementById('serviceSelect').value;
    var subServiceSelect = document.getElementById('subServiceSelect');
    var div = document.querySelector('.div');

    // Reset sub-service dropdown
    subServiceSelect.innerHTML = '<option value="">Select Sub-Service</option>';

    // Check if the selected service has sub-services
    if (serviceId !== '') {
        // Make an AJAX request to fetch sub-services
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_data/get_subservices.php?service_id=' + serviceId, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var subServices = JSON.parse(xhr.responseText);

                // Populate the sub-service dropdown
                if (subServices.length > 0) {
                    div.classList.add("show")

                    subServices.forEach(function (subService) {
                        var option = document.createElement('option');
                        option.value = subService.id_service;
                        option.textContent = subService.name_service;
                        subServiceSelect.appendChild(option);
                    });
                } else {
                    div.classList.remove("show")

                }
            }
        };
        xhr.send();
    }
}

var categorySelect = document.getElementById("catgorySelect");
categorySelect.addEventListener("change", getServices)

var serviceSelect = document.getElementById("serviceSelect");
serviceSelect.addEventListener("change", getSubServices)