const geoInfo = document.getElementById("geoInfo");
const locationBtn = document.getElementById("geoBtn");

// eslint-disable-next-line no-unused-vars
function getLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition);
	} else {
		geoInfo.innerHTML = "Geolocation is not supported by this browser.";
	}
}

function showPosition(position) {
	const lat = position.coords.latitude;
	const lon = position.coords.longitude;

	console.log("Coordinates:", lat, lon);

	fetch(`/api/get-city?lat=${lat}&lon=${lon}`)
		.then((response) => response.json())
		.then((data) => {
			let cityName = "Unknown";

			if (data.status === "success" && data.city) {
				cityName = data.city;
				console.log("City name:", cityName);
			} else {
				console.warn("City not found in backend response.");
			}

			geoInfo.innerHTML = `
				City: <strong id="city-name" data-testid="city-name">${cityName}</strong><br>
				Latitude: <strong id="lat-value" data-testid="lat-value">${lat}</strong><br>
				Longitude: <strong id="lon-value" data-testid="lon-value">${lon}</strong><br>
				<a id="map-link" data-testid="map-link" href="https://maps.google.com/?q=${lat},${lon}" target="_blank">See it on Google</a>
			`;

			// Hide the button
			if (locationBtn) {
				locationBtn.style.display = "none";
			}
		})
		.catch((error) => {
			console.error("Error calling backend:", error);
			geoInfo.innerHTML = `
				Latitude: <strong id="lat-value" data-testid="lat-value">${lat}</strong><br>
				Longitude: <strong id="lon-value" data-testid="lon-value">${lon}</strong><br>
				<a id="map-link" data-testid="map-link" href="https://maps.google.com/?q=${lat},${lon}" target="_blank">See it on Google</a>
			`;

			if (locationBtn) {
				locationBtn.style.display = "none";
			}
		});
}
