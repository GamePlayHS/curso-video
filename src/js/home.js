document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const courses = document.querySelectorAll('.course-item');

    function filterCourses() {
        debugger;
        const filter = searchInput.value.toLowerCase();

        courses.forEach(function (course) {
            const title = course.querySelector('.card-title').textContent.toLowerCase();
            if (title.includes(filter)) {
                course.style.display = '';
            } else {
                course.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('keyup', filterCourses);

    // Torna a função global para funcionar com onkeyup="filterCourses()" no HTML
    window.filterCourses = filterCourses;
});