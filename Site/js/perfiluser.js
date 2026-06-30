        document.getElementById("toggleBioEdit").onclick = function() {

            const form = document.getElementById("bioForm");

            if (form.style.display == "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        };

        document.getElementById("avatarInput").onchange = function() {
            document.getElementById("guardarAvatarBtn").click();
        };