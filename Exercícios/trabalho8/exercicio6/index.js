window.onload = function () {
    const buttons = document.querySelectorAll("nav button");

    buttons.forEach((button, index) => {
        button.addEventListener("click", () => openTab(index));
    });

    openTab(0);
}

function openTab(index) {
    const tabs = document.querySelectorAll(".tabs section");
    const navButtons = document.querySelectorAll("nav button");

    tabs.forEach(tab => tab.classList.remove("tabActive"));
    navButtons.forEach(button => button.classList.remove("buttonActive"));

    tabs[index].classList.add("tabActive");
    navButtons[index].classList.add("buttonActive");
}