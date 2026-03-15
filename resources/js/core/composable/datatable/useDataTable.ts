import { ref } from 'vue';
import type { IPaginationRequest, ISortBy } from '@/core/types/IApi';

export function useGenericTable(fetchData: (params: IPaginationRequest) => void) {
    const currentSearchQuery = ref("");
    const page = ref(1);
    const itemsPerPage = ref(15);
    const sortBy = ref<ISortBy>({
        sort: "id",
        order: "asc"
    });

    const handleTableOptionsChange = (options: any) => {
        page.value = options.page;
        itemsPerPage.value = options.itemsPerPage;
        if (options.sortBy && options.sortBy.length > 0) {
            sortBy.value = {
                sort: options.sortBy[0].key,
                order: options.sortBy[0].order
            };
        } else {
            sortBy.value = {
                sort: "id",
                order: "asc"
            };
        }

        const params: IPaginationRequest = {
            page: page.value,
            limit: itemsPerPage.value,
            search: ""
        };

        if (currentSearchQuery.value) {
            params.search = currentSearchQuery.value;
        }

        if (sortBy.value) {
            params.sortBy = sortBy.value;
        }

        fetchData(params);
    };

    const handleSearch = (query: string) => {
        currentSearchQuery.value = query;
        page.value = 1;
        fetchData({
            search: currentSearchQuery.value,
            page: page.value,
            limit: itemsPerPage.value,
            sortBy: sortBy.value
        });
    };

    const handleRefresh = () => {
        page.value = 1;
        fetchData({
            search: currentSearchQuery.value,
            page: page.value,
            limit: itemsPerPage.value,
            sortBy: sortBy.value
        });
    };

    const resetPage = () => {
        page.value = 1;
    };

    return {
        currentSearchQuery,
        handleTableOptionsChange,
        handleSearch,
        handleRefresh,
        resetPage
    };
}