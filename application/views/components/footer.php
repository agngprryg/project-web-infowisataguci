</main>
</body>

</html>
<script>
    function toggleDropdown() {
        var dropdown = document.getElementById("dropdownMenu");
        dropdown.classList.toggle("hidden");
    }

    // Optional: Click outside to close
    document.addEventListener("click", function(event) {
        const dropdown = document.getElementById("dropdownMenu");
        const button = event.target.closest("button");
        if (!dropdown.contains(event.target) && !button) {
            dropdown.classList.add("hidden");
        }
    });
</script>