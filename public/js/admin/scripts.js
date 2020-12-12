document.addEventListener("DOMContentLoaded", function () {

    const grupos = document.getElementsByClassName('grupomenu');
    for (i = 0; i < grupos.length; i++) {
        if (grupos[i].children.length === 0) {
            var grupomenu = grupos[i].parentElement;
            grupomenu.classList.add('d-none');
        }
    }

    var menu = $('ul.nav-sidebar').find('a.active').parents('li.has-treeview');
    menu.addClass('menu-open');
    menu.children('a').addClass('active');

});