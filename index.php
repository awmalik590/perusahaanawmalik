<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - Profil Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        .background-image {
            background-image: url('http://3.bp.blogspot.com/-4d5f5QguFSQ/UM_lndWTO4I/AAAAAAAAAGU/wAjzuMVJDd8/s1600/Copy+of+DSC09834+Gedung-gedung+Perkantoran+di+Jl.+Thamrin%252C+Jakarta+by+Sahat+Simarmata.JPG');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="bg-gray-100 background-image">
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold mb-6 text-center text-black">Profil Perusahaan</h1>

        <!-- Input Search -->
        <div class="flex justify-center mb-6">
            <input id="searchInput" type="text" class="p-2 border border-gray-300 rounded w-full max-w-lg" placeholder="Cari profil...">
        </div>

        <!-- Button Tambah Profil -->
        <div class="text-center mb-4">
            <button onclick="showAddProfileModal()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Tambah Profil</button>
        </div>

        <!-- Daftar Profil -->
        <div id="profiles" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Profil akan dimuat di sini -->
        </div>
    </div>

    <!-- Modal Tambah/Edit Profil -->
    <div id="addProfileModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 id="modalTitle" class="text-2xl font-bold mb-4">Tambah Profil Baru</h2>
            <div class="mb-4">
                <input id="name" type="text" placeholder="Nama" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <input id="role" type="text" placeholder="Jabatan" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <input id="email" type="email" placeholder="Email" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <input id="phone" type="text" placeholder="Nomor Telepon" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <input id="address" type="text" placeholder="Alamat" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <input id="birthday" type="date" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <select id="gender" class="w-full p-2 border border-gray-300 rounded">
                    <option value="" disabled selected>Pilih Gender</option>
                    <option value="Male">Laki-Laki</option>
                    <option value="Female">Perempuan</option>
                </select>
            </div>
            <div class="mb-4">
                <input id="skills" type="text" placeholder="Keahlian (Pisahkan dengan koma)" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <input id="socialMedia" type="url" placeholder="Link Media Sosial" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <input id="image" type="text" placeholder="URL Gambar" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="flex justify-end">
                <button onclick="hideAddProfileModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">Batal</button>
                <button id="saveButton" onclick="saveProfile()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
            </div>
        </div>
    </div>

    <script>
        // Ambil data profil dari localStorage
        const profiles = JSON.parse(localStorage.getItem('profiles')) || [];

        // Tampilkan daftar profil
        function renderProfiles(filter = '') {
            const profilesContainer = document.getElementById('profiles');
            profilesContainer.innerHTML = '';

            profiles
                .filter(profile => profile.name.toLowerCase().includes(filter.toLowerCase()))
                .forEach((profile, index) => {
                    const profileCard = `
                        <div class="bg-white p-6 rounded-lg shadow-lg transform transition duration-500 hover:scale-105">
                            <div class="flex items-center mb-4">
                                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-blue-500">
                                    <img src="${profile.image}" alt="Profile picture of ${profile.name}" class="w-full h-full object-cover">
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-xl font-bold text-blue-600">${profile.name}</h2>
                                    <p class="text-gray-600">${profile.role}</p>
                                </div>
                            </div>
                            <p class="mb-2"><strong>Email:</strong> ${profile.email}</p>
                            <p class="mb-2"><strong>Phone:</strong> ${profile.phone}</p>
                            <p><strong>Location:</strong> ${profile.address}</p>
                            <div class="flex justify-between mt-4">
                                <a href="halaman detail.html?id=${index}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Lihat Profil</a>
                                <button onclick="editProfile(${index})" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>
                                <button onclick="deleteProfile(${index})" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                            </div>
                        </div>
                    `;
                    profilesContainer.innerHTML += profileCard;
                });
        }

        // Tampilkan modal tambah/edit profil
        function showAddProfileModal(editIndex = null) {
    console.log("Modal dibuka", editIndex); // Debug
    document.getElementById('addProfileModal').classList.remove('hidden');
    document.getElementById('modalTitle').textContent = editIndex !== null ? 'Edit Profil' : 'Tambah Profil Baru';

    // Isi form jika sedang mengedit
    if (editIndex !== null) {
        const profile = profiles[editIndex];
        document.getElementById('name').value = profile.name || '';
        document.getElementById('role').value = profile.role || '';
        document.getElementById('email').value = profile.email || '';
        document.getElementById('phone').value = profile.phone || '';
        document.getElementById('address').value = profile.address || '';
        document.getElementById('birthday').value = profile.birthday || '';
        document.getElementById('gender').value = profile.gender || '';
        document.getElementById('skills').value = profile.skills || '';
        document.getElementById('socialMedia').value = profile.socialMedia || '';
    } else {
        // Reset semua input
        document.getElementById('name').value = '';
        document.getElementById('role').value = '';
        document.getElementById('email').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('address').value = '';
        document.getElementById('birthday').value = '';
        document.getElementById('gender').value = '';
        document.getElementById('skills').value = '';
        document.getElementById('socialMedia').value = '';
    }
}

function saveProfile(editIndex = null) {
    const name = document.getElementById('name').value;
    const role = document.getElementById('role').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;
    const birthday = document.getElementById('birthday').value;
    const gender = document.getElementById('gender').value;
    const skills = document.getElementById('skills').value;
    const socialMedia = document.getElementById('socialMedia').value;
    const image = document.getElementById('image').value || 'https://via.placeholder.com/150';

    console.log('Image URL:', image); // Debugging

    const newProfile = { name, role, email, phone, address, birthday, gender, skills, socialMedia, image };

    if (editIndex !== null) {
        profiles[editIndex] = newProfile;
        console.log('Profil diperbarui:', profiles[editIndex]);
    } else {
        profiles.push(newProfile);
        console.log('Profil baru ditambahkan:', newProfile);
    }

    localStorage.setItem('profiles', JSON.stringify(profiles));
    renderProfiles();
    hideAddProfileModal();
}

function hideAddProfileModal() {
    const modal = document.getElementById('addProfileModal');
    if (modal) {
        modal.classList.add('hidden'); // Menyembunyikan modal dengan menambahkan kelas 'hidden'
        console.log('Modal ditutup'); // Debugging untuk memastikan fungsi dipanggil
    } else {
        console.error('Elemen modal tidak ditemukan!');
    }
}



        // Hapus profil
        function deleteProfile(index) {
            if (confirm("Apakah Anda yakin ingin menghapus profil ini?")) {
                profiles.splice(index, 1);
                localStorage.setItem('profiles', JSON.stringify(profiles));
                renderProfiles();
            }
        }

        // Cari profil
        document.getElementById('searchInput').addEventListener('input', function () {
            renderProfiles(this.value);
        });

        // Render profil saat halaman dimuat
        renderProfiles();
    </script>
</body>
</html>
