 // Membuat efek salju
        document.addEventListener('DOMContentLoaded', () => {
            const createSnowflake = () => {
                const snowflake = document.createElement('div');
                snowflake.classList.add('snowflake');
                snowflake.style.left = Math.random() * window.innerWidth + 'px';
                snowflake.style.fontSize = Math.random() * 20 + 20 + 'px';
                snowflake.style.opacity = Math.random() * 0.5 + 0.5;
                snowflake.style.animation = `fall-snow ${Math.random() * 3 + 4}s linear infinite`;
                snowflake.innerHTML = '❄';
                document.body.appendChild(snowflake);

                setTimeout(() => {
                    snowflake.remove();
                }, 7000);
            };

            setInterval(createSnowflake, 50); // Membuat salju setiap 50ms
        });