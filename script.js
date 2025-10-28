// Terminal data
const terminals = [
  { name: "VGC Terminal", coords: [120.9830, 14.7066] },
  { name: "Karuhatan Terminal", coords: [120.980, 14.710] },
  { name: "Maysan Terminal", coords: [120.985, 14.715] },
  { name: "Mavanoda Terminal", coords: [120.972370, 14.693850] },
  { name: "MASTODA Terminal", coords: [120.9785331, 14.6821576] },
  { name: "MASTODA Sub - Terminal 1", coords: [120.9800703, 14.6810202] },
  { name: "MASTODA Sub - Terminal 3", coords: [120.9822409, 14.6807525] },
  { name: "FATATODA Terminal", coords: [120.9801478, 14.6786276] },
  { name: "FATATODA Sub - Terminal", coords: [120.9811110, 14.6790483] },
  { name: "FATATODA Terminal 2", coords: [120.9834875, 14.6804238] },
  { name: "ASCTODA Terminal", coords: [120.9780111, 14.6824262] },
  { name: "ASCTODA Terminal 2", coords: [120.9758491, 14.6859664] },
  { name: "MTODA Terminal 1", coords: [120.9827228, 14.6740721] },
  { name: "MTODA Terminal 2", coords: [120.990848, 14.675692] },
  { name: "MTODA Terminal 3", coords: [120.992750, 14.677758] },
  { name: "MTODA Terminal 4 (Liwayway)", coords: [120.994981, 14.680327] },
  { name: "EFPTODA Terminal", coords: [120.981136, 14.674267] },
  { name: "DOPTODA Terminal", coords: [120.9778165, 14.6811883] },
  { name: "GTDLTODA Terminal", coords: [120.987430, 14.684210] },
  { name: "MAPASATODA Terminal", coords: [120.991046, 14.685390] },
  { name: "SFPTODA Terminal", coords: [120.975033, 14.687552] },
  { name: "SFPTODA Sub - Terminal 1", coords: [120.9712381, 14.6828681] },
  { name: "SFPTODA Sub - Terminal 2", coords: [120.9693657, 14.6817543] },
  { name: "PAGUBRIJETODA Terminal", coords: [120.974872, 14.688651] },
  { name: "INTODA Terminal", coords: [120.996975, 14.686742] },
  { name: "GTUTODA Terminal", coords: [121.0087165, 14.6929564] },
  { name: "GTUTODA Terminal 1", coords: [121.008715, 14.693006] },
  { name: "GTUTODA Terminal 2", coords: [121.001192, 14.688084] },
  { name: "SQTODA Terminal", coords: [121.0014923, 14.6878900] },
  { name: "PMUTODA Terminal", coords: [120.999438, 14.686221] },
  { name: "FVTODA Terminal", coords: [120.9881195, 14.7044778] },
  { name: "Macanojoda Terminal", coords: [120.970041, 14.693964] },
  { name: "Market Terminal", coords: [120.9643739, 14.6922034] },
  { name: "MSJDTTODA Terminal", coords: [120.9641026, 14.6924224] },
  { name: "SANPATODA Terminal", coords: [120.9955959, 14.6875985] },
  { name: "SANPATODA Terminal 2", coords: [120.9938922, 14.6942838] },
  { name: "BALMATODA Terminal", coords: [120.9642538, 14.6969740] },
  { name: "BALMATODA Terminal 2", coords: [120.9659856, 14.6993050] },
  { name: "BALMATODA Terminal 3", coords: [120.9680714, 14.7011626] },
  { name: "BALMATODA Terminal 4", coords: [120.9719637, 14.7032287] },
  { name: "BALMATODA Extension Terminal", coords: [120.9787590, 14.7004205] },
  { name: "VCHSTODA Terminal", coords: [120.9793107, 14.6991709] },
  { name: "VCHSTODA Terminal 2", coords: [120.988164, 14.6964136] }
];

document.addEventListener('DOMContentLoaded', function() {
  setupMainSearchBar();
  setupRouteInputs();
  setupRouteSearch();
  setupSavedRoutes();
});

// Setup main search bar
function setupMainSearchBar() {
  const mainSearch = document.getElementById('mainSearch');
  
  if (!mainSearch) return;

  const wrapper = mainSearch.parentElement;
  const dropdown = document.createElement('div');
  dropdown.className = 'search-dropdown';
  wrapper.appendChild(dropdown);

  mainSearch.addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    dropdown.innerHTML = '';

    if (searchText.length < 1) {
      dropdown.style.display = 'none';
      return;
    }

    const matches = terminals.filter(t => t.name.toLowerCase().includes(searchText));

    if (matches.length === 0) {
      dropdown.style.display = 'none';
      return;
    }

    matches.slice(0, 5).forEach(terminal => {
      const item = document.createElement('div');
      item.className = 'search-item';
      item.textContent = terminal.name;
      
      item.addEventListener('click', function() {
        // Go to map page with this terminal
        sessionStorage.setItem('searchTerminal', JSON.stringify(terminal));
        window.location.href = 'map.html';
      });
      
      dropdown.appendChild(item);
    });

    dropdown.style.display = 'block';
  });

  document.addEventListener('click', function(e) {
    if (!wrapper.contains(e.target)) {
      dropdown.style.display = 'none';
    }
  });
}

// Setup from/to route inputs
function setupRouteInputs() {
  const fromInput = document.querySelector('input[placeholder*="Current Location"]');
  const toInput = document.querySelector('input[placeholder*="Destination"]');

  if (fromInput) createRouteAutocomplete(fromInput);
  if (toInput) createRouteAutocomplete(toInput);
}

// Create autocomplete for route inputs (from/to)
function createRouteAutocomplete(input) {
  const wrapper = input.parentElement;
  const dropdown = document.createElement('div');
  dropdown.className = 'search-dropdown';
  wrapper.appendChild(dropdown);

  input.addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    dropdown.innerHTML = '';

    if (searchText.length < 1) {
      dropdown.style.display = 'none';
      return;
    }

    const matches = terminals.filter(t => t.name.toLowerCase().includes(searchText));

    if (matches.length === 0) {
      dropdown.style.display = 'none';
      return;
    }

    matches.slice(0, 5).forEach(terminal => {
      const item = document.createElement('div');
      item.className = 'search-item';
      item.textContent = terminal.name;
      
      item.addEventListener('click', function() {
        input.value = terminal.name;
        dropdown.style.display = 'none';
      });
      
      dropdown.appendChild(item);
    });

    dropdown.style.display = 'block';
  });

  document.addEventListener('click', function(e) {
    if (!wrapper.contains(e.target)) {
      dropdown.style.display = 'none';
    }
  });
}

// Setup route search button
function setupRouteSearch() {
  const findBtn = document.querySelector('.btn');
  
  if (!findBtn) return;

  findBtn.addEventListener('click', function() {
    const fromInput = document.querySelector('input[placeholder*="Current Location"]');
    const toInput = document.querySelector('input[placeholder*="Destination"]');
    
    const fromValue = fromInput ? fromInput.value.trim() : '';
    const toValue = toInput ? toInput.value.trim() : '';

    if (!fromValue || !toValue) {
      alert('Please enter both starting point and destination');
      return;
    }

    const fromTerminal = terminals.find(t => t.name === fromValue);
    const toTerminal = terminals.find(t => t.name === toValue);

    if (!fromTerminal || !toTerminal) {
      alert('Please select valid terminals from the suggestions');
      return;
    }

    sessionStorage.setItem('searchFrom', JSON.stringify(fromTerminal));
    sessionStorage.setItem('searchTo', JSON.stringify(toTerminal));

    window.location.href = 'map.html';
  });
}

// Setup saved routes
function setupSavedRoutes() {
  const savedCards = document.querySelectorAll('.saved-route-card');
  
  savedCards.forEach(card => {
    card.addEventListener('click', function() {
      const routeText = this.querySelector('.route-sub').textContent;
      const parts = routeText.split(' → ');
      
      const fromInput = document.querySelector('input[placeholder*="Current Location"]');
      const toInput = document.querySelector('input[placeholder*="Destination"]');
      
      if (fromInput && toInput && parts.length === 2) {
        fromInput.value = parts[0].trim();
        toInput.value = parts[1].trim();
      }
    });
  });
}
