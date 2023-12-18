document.addEventListener('DOMContentLoaded', function () {
    const menuList = document.getElementById('menu-list');
    const addItemForm = document.getElementById('addItemForm');

    addItemForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const itemName = document.getElementById('itemName').value;
        const itemImage = document.getElementById('itemImage').value;
        const itemDescription = document.getElementById('itemDescription').value;
        const itemPrice = document.getElementById('itemPrice').value;

        // TODO: Send this data to the server for processing (e.g., using fetch or AJAX)

        // For simplicity, let's just display the added item in the menu
        const menuItem = document.createElement('div');
        menuItem.innerHTML = `
            <h3>${itemName}</h3>
            <img src="${itemImage}" alt="${itemName}">
            <p>${itemDescription}</p>
            <p>Price: ${itemPrice}</p>
        `;
        menuList.appendChild(menuItem);

        // Clear the form
        addItemForm.reset();
    });
});

function handleClick(day) {
    // Assuming you have corresponding divs for each day
    var contentDivId = day.toLowerCase() + 'Content';

    // Call the show function to display the content for the clicked day
    show(contentDivId);
  }

  function show(shown) {
    // Hide all content divs
    var allContentDivs = document.querySelectorAll('.content');
    allContentDivs.forEach(function(div) {
      div.style.display = 'none';
    });

    // Show the selected content div
    document.getElementById(shown).style.display = 'block';
  }

 // Function to get the current day of the week
function getCurrentDay() {
    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var currentDate = new Date();
    var currentDayIndex = currentDate.getDay(); // 0 for Sunday, 1 for Monday, and so on
    return days[currentDayIndex];
}

// Function to show content based on the current day
function showContentBasedOnDay() {
    var currentDay = getCurrentDay();
    var contentDivId = currentDay.toLowerCase() + 'Content';
    show(contentDivId);
}

// Function to show content
function show(shown) {
    // Hide all content divs
    var allContentDivs = document.querySelectorAll('.content');
    allContentDivs.forEach(function(div) {
        div.style.display = 'none';
    });

    // Show the selected content div
    document.getElementById(shown).style.display = 'block';
}

// Call the function to show content based on the current day when the page loads
window.onload = showContentBasedOnDay;
