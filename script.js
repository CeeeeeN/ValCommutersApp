document.addEventListener('DOMContentLoaded', function() {
  
  initializeApp();
  
});

function initializeApp() {
  setupRouteSearch();
  setupSavedRoutes();
  setupAccountFunctions();
  setupNavigation();
  setupGeolocation();
}

function setupRouteSearch() {
  const findRouteBtn = document.querySelector('.btn');
  const fromInput = document.querySelector('input[placeholder*="Current Location"]');
  const toInput = document.querySelector('input[placeholder*="Destination"]');
  
  if (findRouteBtn) {
    findRouteBtn.addEventListener('click', function() {
      const fromLocation = fromInput ? fromInput.value : '';
      const toLocation = toInput ? toInput.value : '';
      
      if (!fromLocation || !toLocation) {
        alert('Please enter both starting point and destination.');
        return;
      }
      
      findBestRoute(fromLocation, toLocation);
    });
  }
}

function findBestRoute(from, to) {
  console.log(`Finding route from ${from} to ${to}`);
  
  alert(`Searching for best route from ${from} to ${to}...`);
  
}

function setupSavedRoutes() {
  const savedRouteCards = document.querySelectorAll('.saved-route-card');
  
  savedRouteCards.forEach(card => {
    card.addEventListener('click', function() {
      const routeTitle = this.querySelector('.route-title').textContent;
      const routeSub = this.querySelector('.route-sub').textContent;
      
      loadSavedRoute(routeTitle, routeSub);
    });
    
    card.style.cursor = 'pointer';
  });
}

function loadSavedRoute(title, route) {
  console.log(`Loading saved route: ${title} - ${route}`);
  
  const [from, to] = route.split(' → ');
  
  const fromInput = document.querySelector('input[placeholder*="Current Location"]');
  const toInput = document.querySelector('input[placeholder*="Destination"]');
  
  if (fromInput && toInput) {
    fromInput.value = from;
    toInput.value = to;
  }
  
  alert(`Loaded route: ${title}`);
}

function setupAccountFunctions() {
  const editProfileBtn = document.querySelector('.secondary-btn:nth-child(1)');
  const manageSavedRoutesBtn = document.querySelector('.secondary-btn:nth-child(2)');
  const aboutHelpBtn = document.querySelector('.secondary-btn:nth-child(3)');
  const logoutBtn = document.querySelector('.logout-btn');
  
  if (editProfileBtn) {
    editProfileBtn.addEventListener('click', function() {
      editProfile();
    });
  }
  
  if (manageSavedRoutesBtn) {
    manageSavedRoutesBtn.addEventListener('click', function() {
      manageSavedRoutes();
    });
  }
  
  if (aboutHelpBtn) {
    aboutHelpBtn.addEventListener('click', function() {
      showAboutHelp();
    });
  }
  
  if (logoutBtn) {
    logoutBtn.addEventListener('click', function() {
      logout();
    });
  }
}

function editProfile() {
  console.log('Edit Profile clicked');
  alert('Edit Profile feature');
}

function manageSavedRoutes() {
  console.log('Manage Saved Routes clicked');
  alert('Manage Saved Routes feature');
}

function showAboutHelp() {
  console.log('About / Help clicked');
  alert('About / Help\n\nVal Commuters - Your travel companion');
}

function logout() {
  const confirmLogout = confirm('Are you sure you want to logout?');
  
  if (confirmLogout) {
    console.log('User logged out');
    alert('You have been logged out successfully');
    window.location.href = 'login.html';
  }
}

function setupNavigation() {
  const navItems = document.querySelectorAll('.nav-item');
  
  navItems.forEach(item => {
    item.addEventListener('click', function(e) {
      navItems.forEach(nav => nav.classList.remove('active'));
      
      this.classList.add('active');
    });
  });
}

function setupGeolocation() {
  const fromInput = document.querySelector('input[placeholder*="Current Location"]');
  
  if (fromInput && navigator.geolocation) {
    fromInput.addEventListener('focus', function() {
      if (this.value === '') {
        getCurrentLocation();
      }
    });
  }
}

function getCurrentLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        
        console.log(`Current location: ${lat}, ${lon}`);
        
        reverseGeocode(lat, lon);
      },
      function(error) {
        console.error('Error getting location:', error);
        alert('Unable to get your current location');
      }
    );
  } else {
    alert('Geolocation is not supported by your browser');
  }
}

function reverseGeocode(lat, lon) {
  const fromInput = document.querySelector('input[placeholder*="Current Location"]');
  
  if (fromInput) {
    fromInput.value = 'Maysan, Valenzuela City';
  }
}

function setupNearbyStops() {
  const stopRows = document.querySelectorAll('.stop-row');
  
  stopRows.forEach(row => {
    row.addEventListener('click', function() {
      const stopName = this.querySelector('span:first-child').textContent;
      const distance = this.querySelector('.distance').textContent;
      
      showStopDetails(stopName, distance);
    });
    
    row.style.cursor = 'pointer';
  });
}

function showStopDetails(name, distance) {
  alert(`Stop: ${name}\nDistance: ${distance}\n\nClick to view route details`);
}

function setupRouteFilters() {
  const routeDots = document.querySelectorAll('.route-dot');
  
  routeDots.forEach(dot => {
    dot.parentElement.addEventListener('click', function() {
      const routeNumber = this.querySelector('span:last-child').textContent;
      filterByRoute(routeNumber);
    });
    
    dot.parentElement.style.cursor = 'pointer';
  });
}

function filterByRoute(routeNumber) {
  console.log(`Filtering by ${routeNumber}`);
  alert(`Showing ${routeNumber} on map`);
}

function addInputValidation() {
  const inputs = document.querySelectorAll('input');
  
  inputs.forEach(input => {
    input.addEventListener('blur', function() {
      if (this.hasAttribute('required') && this.value.trim() === '') {
        this.style.borderColor = '#d94233';
      } else {
        this.style.borderColor = '#ddd';
      }
    });
  });
}

function animateOnScroll() {
  const cards = document.querySelectorAll('.saved-route-card, .route-card');
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  });
  
  cards.forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'all 0.5s ease';
    observer.observe(card);
  });
}

setTimeout(() => {
  setupNearbyStops();
  setupRouteFilters();
  addInputValidation();
  animateOnScroll();
}, 100);