import { ref } from 'vue';

export function useCrudDialogs(options: { onDelete: (item: any) => Promise<void>; onRestore?: (item: any) => Promise<void> }) {
    const dialogDelete = ref(false);
    const dialogRestore = ref(false);
    const selectedItem = ref<any | null>(null);

    const confirmDelete = (item: any) => {
        selectedItem.value = item;
        dialogDelete.value = true;
    };

    const deleteItemConfirm = async () => {
        if (selectedItem.value) {
            await options.onDelete(selectedItem.value);
        }
        dialogDelete.value = false;
        selectedItem.value = null;
    };

    const confirmRestore = (item: any) => {
        if (!options.onRestore) return;
        selectedItem.value = item;
        dialogRestore.value = true;
    };

    const restoreItemConfirm = async () => {
        if (selectedItem.value && options.onRestore) {
            await options.onRestore(selectedItem.value);
        }
        dialogRestore.value = false;
        selectedItem.value = null;
    };

    return {
        dialogDelete,
        dialogRestore,
        selectedItem,
        confirmDelete,
        deleteItemConfirm,
        confirmRestore,
        restoreItemConfirm
    };
}