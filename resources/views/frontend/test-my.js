const dropdownToggles = document.querySelectorAll(".dropdown-toggle");
dropdownToggles.forEach(dropdownToggle => {
    dropdownToggle.addEventListener("click", function (e) {
        console.log(e);
    });
});

