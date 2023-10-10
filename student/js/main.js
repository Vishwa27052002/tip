document.getElementById('view-timetable-link').addEventListener('click', function(e) {
    e.preventDefault();

    fetch('php/view_timetable.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Display timetable data on the dashboard
        const timetableSection = document.getElementById('timetable-section');
        timetableSection.innerHTML = ''; // Clear previous content

        if (data && data.length > 0) {
            const table = document.createElement('table');
            table.innerHTML = `
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Tutor</th>
                    </tr>
                </thead>
                <tbody>
                ${data.map(session => `
                    <tr>
                        <td>${session.date}</td>
                        <td>${session.start_time}</td>
                        <td>${session.end_time}</td>
                        <td>${session.tutor}</td>
                    </tr>
                `).join('')}
                </tbody>
            `;
            timetableSection.appendChild(table);
        } else {
            timetableSection.textContent = 'No sessions found.';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});


document.getElementById('join-queue-link').addEventListener('click', function(e) {
    e.preventDefault();

    fetch('php/join_queue.php', {
        method: 'POST',
        body: JSON.stringify({ action: 'join_queue' }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Display session queue data on the dashboard
        document.getElementById('queue-section').innerHTML = data;
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

document.getElementById('view-expertise-link').addEventListener('click', function(e) {
    e.preventDefault();

    fetch('php/view_expertise.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Display tutor expertise data on the dashboard
        const expertiseSection = document.getElementById('expertise-section');
        expertiseSection.innerHTML = ''; // Clear previous content

        if (data && data.length > 0) {
            const ul = document.createElement('ul');
            ul.innerHTML = data.map(expertise => `<li>${expertise.subject} - ${expertise.tutor_name}</li>`).join('');
            expertiseSection.appendChild(ul);
        } else {
            expertiseSection.textContent = 'No tutor expertise available.';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
document.getElementById('view-statistics-link').addEventListener('click', function(e) {
    e.preventDefault();

    fetch('php/view_statistics.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Display student statistics on the dashboard
        const statisticsSection = document.getElementById('statistics-section');
        statisticsSection.innerHTML = ''; // Clear previous content

        if (data && data.length > 0) {
            const ul = document.createElement('ul');
            ul.innerHTML = data.map(statistic => `<li>${statistic.stat_name}: ${statistic.value}</li>`).join('');
            statisticsSection.appendChild(ul);
        } else {
            statisticsSection.textContent = 'No statistics available.';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// Fetch and display the list of available learning materials
function listLearningMaterials() {
    fetch('php/access_materials.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const materialsSection = document.getElementById('materials-section');
        materialsSection.innerHTML = ''; // Clear previous content

        if (data && data.length > 0) {
            const ul = document.createElement('ul');
            data.forEach(material => {
                const li = document.createElement('li');
                const link = document.createElement('a');
                link.href = `php/access_materials.php?material=${encodeURIComponent(material)}`;
                link.textContent = material;
                li.appendChild(link);
                ul.appendChild(li);
            });
            materialsSection.appendChild(ul);
        } else {
            materialsSection.textContent = 'No learning materials available.';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Add an event listener to the "Access Learning Materials" link
document.getElementById('access-materials-link').addEventListener('click', function(e) {
    e.preventDefault();
    listLearningMaterials();
});


