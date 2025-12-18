                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('layoutSidenav_nav');
            const content = document.getElementById('layoutSidenav_content');
            
            if (sidebar.style.width === '0px') {
                sidebar.style.width = '225px';
                content.style.marginLeft = '225px';
            } else {
                sidebar.style.width = '0px';
                content.style.marginLeft = '0px';
            }
        });
    </script>
</body>
</html>