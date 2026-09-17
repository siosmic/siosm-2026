// window.addEventListener('load', function () {
document.addEventListener("DOMContentLoaded", function() {
   const acfFormModals = document.querySelectorAll(".acf-form-modal");
   modalOpened = false;

   function closeModal(e){
      const modalWrapper = e.querySelector('.modal-wrapper');
      const modalEditWindow = e.querySelector('.modal-edit-window');
      const modalOverlay = e.querySelector('.modal-overlay');
      if( modalOpened = true ){
         modalWrapper.classList.add('pointer-events-none');
         modalEditWindow.classList.add('scale-0');
         modalOverlay.classList.add('opacity-0');
         document.body.classList.remove('overflow-hidden');
         modalOpened = false;
      }
   }
   function openModal(e){
      modalOpened = true;
      const modalWrapper = e.querySelector('.modal-wrapper');
      const modalEditWindow = e.querySelector('.modal-edit-window');
      const modalOverlay = e.querySelector('.modal-overlay');

      modalWrapper.classList.remove('pointer-events-none');
      modalEditWindow.classList.remove('scale-0');
      modalOverlay.classList.remove('opacity-0');
      document.body.classList.add('overflow-hidden');
   }

   Array.from(acfFormModals).forEach(element => {
      const modalCloseButton = element.querySelector('.modal-close');
      const modalOverlay = element.querySelector('.modal-overlay');
      const modalButton = element.querySelector('.modal-button');
      
      modalButton.addEventListener('click', () => {
         openModal(element);
      });

      modalOverlay.addEventListener("click", function() {
         closeModal(element);
      });

      modalCloseButton.addEventListener("click", function() {
         closeModal(element);
      });

      document.addEventListener("keyup", function(event) {
         if (event.code === "Escape") {
            closeModal(element);
         }
      });
   });

});