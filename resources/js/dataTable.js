/**
 * DataTable Alpine.js Component
 * 
 * Provides client-side search/filter functionality for server-rendered tables.
 * Filters visible rows by matching the search term against each row's text content.
 */
document.addEventListener('alpine:init', () => {
    Alpine.data('dataTable', () => ({
        search: '',
        visibleCount: 0,
        totalCount: 0,

        init() {
            this.totalCount = this.getRows().length;
            this.visibleCount = this.totalCount;

            this.$watch('search', () => {
                this.filterRows();
            });
        },

        getRows() {
            if (!this.$refs.tableBody) return [];
            return Array.from(this.$refs.tableBody.querySelectorAll('tr[data-searchable]'));
        },

        filterRows() {
            const rows = this.getRows();
            const term = this.search.toLowerCase().trim();
            let visible = 0;

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const match = !term || text.includes(term);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            this.visibleCount = visible;
        }
    }));
});
