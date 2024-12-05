window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

    const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('inputPassword');

        togglePassword.addEventListener('click', () => {
            // Toggle jenis input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ubah ikon mata
            togglePassword.classList.toggle('fa-eye');
            togglePassword.classList.toggle('fa-eye-slash');
        });

        // Animasi salju dengan lebih banyak dan lebih besar
        document.addEventListener('DOMContentLoaded', () => {
            const createSnowflake = () => {
                const snowflake = document.createElement('div');
                snowflake.classList.add('snowflake');

                // Posisi horizontal acak dan ukuran salju yang lebih besar
                snowflake.style.left = Math.random() * window.innerWidth + 'px';
                snowflake.style.fontSize = Math.random() * 20 + 20 + 'px';  // Ukuran salju lebih besar
                snowflake.style.opacity = Math.random() * 0.5 + 0.5; // Opasitas acak untuk variasi
                snowflake.style.animation = `fall-snow ${Math.random() * 3 + 4}s linear infinite`;  // Durasi acak antara 4s-7s

                snowflake.innerHTML = '❄'; // Gunakan karakter salju
                document.body.appendChild(snowflake);

                // Menghapus salju setelah animasi selesai
                setTimeout(() => {
                    snowflake.remove();
                }, 7000); // Setelah 7 detik
            };

            // Membuat lebih banyak efek salju setiap 50ms
            setInterval(createSnowflake, 50);
        });
