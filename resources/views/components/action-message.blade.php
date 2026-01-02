@if(session('success'))
    <div id="alert"
         class="fixed top-4 left-1/2 transform -translate-x-1/2
                bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg
                opacity-0 translate-y-[-20px] transition-all duration-500 ease-in-out z-50">
        {{ session('success') }}
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const alert = document.getElementById("alert");
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove("opacity-0", "translate-y-[-20px]");
                    alert.classList.add("opacity-100", "translate-y-0");
                }, 100);
                setTimeout(() => {
                    alert.classList.remove("opacity-100", "translate-y-0");
                    alert.classList.add("opacity-0", "translate-y-[-20px]");
                }, 10000);
            }
        });
    </script>
@endif
