document.addEventListener('DOMContentLoaded', function() {
   var sidebarItems = document.querySelectorAll('.sidebar-list-item a');

   sidebarItems.forEach(function(item) {
       item.addEventListener('click', function(event) {
           event.preventDefault();
           var msg = item.getAttribute('href').split('?msg=')[1];
           history.pushState({}, '', '?msg=' + msg);

           // Show/hide content sections based on the clicked sidebar item
           var contentSections = document.querySelectorAll('.content-sections .app-content');
           contentSections.forEach(function(section) {
               section.classList.add('hidden');
           });
           var contentSection = document.querySelector('.app-content.' + msg);
            if (contentSection) {
                contentSection.classList.remove('hidden');
            }
       });
   });
});