document.addEventListener("DOMContentLoaded", function () {
    var header = document.getElementById('restaurant-header');

    new Waypoint({
        element: document.getElementById('restaurant'),
        handler: function(direction) {
            if (direction === 'down') {
                header.classList.remove('bg-transparent');
                header.classList.add('bg-white', 'border-b', 'border-gray-200');
            } else {
                header.classList.remove('bg-white', 'border-b', 'border-gray-200');
                header.classList.add('bg-transparent');
            }
        },
        offset: '0px'
    });
});