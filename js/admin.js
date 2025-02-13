const hotbarBtns = document.querySelectorAll('div.hotbar-btn');
hotbarBtns.forEach((div) => {
    div.addEventListener('click', showMenu);
})
const menus = document.querySelectorAll(".menu");

function showMenu(){
    menus.forEach((div) => {
        div.style.display = "none";
    })
    const menuID = this.dataset.menu;;
    const menu = document.getElementById(menuID);

    menu.style.display = "flex";
}

menus.forEach((div) =>{
    div.style.display = "none";
});

const activeMenuId = document.getElementById('active-menu').dataset.value;
 document.getElementById(activeMenuId).style.display = "flex";