$(document).ready(function () {
    let input = $("#country");
    const lookupButton = $('#lookup');
    const lookupCitiesButton = $('#lookup-cities');
    let result = $("#result");

    lookupButton.click(function () {
        const userInput = input.val().trim();
        const cleanInput = encodeURIComponent(userInput);

        let url;

        if (cleanInput.length == 0){
            url = `http://localhost/comp2245-assignment5/world.php`;    
        } else {
            url = `http://localhost/comp2245-assignment5/world.php?country=${cleanInput}`;
        }

        // jQuery AJAX request
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'text',  
            success: function (response) {
                result.html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX ERROR: " + status + " - " + error);
            }
        });
    });

    lookupCitiesButton.click(function () {
        const userInput = input.val().trim();
        const cleanInput = encodeURIComponent(userInput);

        let url;

        if (cleanInput.length == 0){
            url = `http://localhost/comp2245-assignment5/world.php`;    
        } else {
            url = `http://localhost/comp2245-assignment5/world.php?country=${cleanInput}&lookup=cities`;
        }

        // jQuery AJAX request
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'text',  
            success: function (response) {
                result.html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX ERROR: " + status + " - " + error);
            }
        });
    });
});
