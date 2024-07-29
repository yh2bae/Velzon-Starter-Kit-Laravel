  <!-- JAVASCRIPT -->
  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
  <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
  <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
  <script src="{{ asset('assets/js/plugins.js') }}"></script>
  <script src="{{ asset('assets/libs/jquery-3.6.0.min.js') }}"></script>

  <!-- Sweet Alerts js -->
  <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

  @stack('scripts')

  <!--datatable js-->
  <script src="{{ asset('assets/libs/datatables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/js/dataTables.buttons.min.js') }}"></script>

  @if (!in_array(Route::currentRouteName(), ['login', 'register', 'password.reset']))
      <script src="{{ asset('assets/js/app.js') }}"></script>
  @endif

  <script>
      @if (session('success'))
          Swal.fire({
              html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Berhasil!</h4><p class="text-muted mx-4 mb-0">{{ session('success') }}</p></div></div>',
              showCancelButton: !0,
              showConfirmButton: !1,
              cancelButtonClass: "btn btn-primary w-xs mb-1",
              cancelButtonText: "Ok",
              buttonsStyling: !1,
              showCloseButton: !0
          })
      @elseif (session('error'))
          Swal.fire({
              html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Oops...! Ada yang salah !</h4><p class="text-muted mx-4 mb-0">{{ session('error') }}</p></div></div>',
              showCancelButton: !0,
              showConfirmButton: !1,
              cancelButtonClass: "btn btn-primary w-xs mb-1",
              cancelButtonText: "Ok",
              buttonsStyling: !1,
              showCloseButton: !0
          })
      @endif

      // Dark Mode
      $(document).ready(function() {
          var html = document.getElementsByTagName("HTML")[0];
          var lightDarkBtn = document.querySelector(".light-dark-mode-");

          function updateIcon() {
              var icon = lightDarkBtn.querySelector("i");
              if (html.getAttribute("data-bs-theme") === "dark") {
                  icon.classList.remove("bx-moon");
                  icon.classList.add("bx-sun");
              } else {
                  icon.classList.remove("bx-sun");
                  icon.classList.add("bx-moon");
              }
          }

          lightDarkBtn.addEventListener("click", function(event) {
              if (html.getAttribute("data-bs-theme") === "dark") {
                  html.setAttribute("data-bs-theme", "light");
                  // localStorage.setItem("theme", "light");
                  sessionStorage.setItem("theme", "light");
              } else {
                  html.setAttribute("data-bs-theme", "dark");
                  // localStorage.setItem("theme", "dark");
                  sessionStorage.setItem("theme", "dark");
              }
              updateIcon();
          });

          if (sessionStorage.getItem("theme") === "dark") {
              html.setAttribute("data-bs-theme", "dark");
          } else {
              html.setAttribute("data-bs-theme", "light");
          }
          updateIcon();
      });
  </script>
