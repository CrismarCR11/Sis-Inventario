<template>
  <v-dialog v-model="dialog" max-width="400">
    <v-card>
      <v-card-title class="text-h5">{{ title }}</v-card-title>
      <v-card-text>{{ message }}</v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="grey-darken-1" variant="text" @click="cancel">
          {{ cancelText }}
        </v-btn>
        <v-btn
          :color="confirmColor"
          variant="text"
          :loading="loading"
          @click="confirm"
        >
          {{ confirmText }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: 'Confirmar acción'
    },
    message: {
        type: String,
        default: '¿Estás seguro de realizar esta acción?'
    },
    confirmText: {
        type: String,
        default: 'Confirmar'
    },
    cancelText: {
        type: String,
        default: 'Cancelar'
    },
    confirmColor: {
        type: String,
        default: 'primary'
    }
});

const emit = defineEmits(['update:modelValue', 'confirm', 'cancel']);

const dialog = ref(props.modelValue);
const loading = ref(false);

watch(() => props.modelValue, (val) => {
    dialog.value = val;
});

watch(dialog, (val) => {
    emit('update:modelValue', val);
});

const confirm = async () => {
    loading.value = true;
    try {
        await emit('confirm');
    } finally {
        loading.value = false;
        dialog.value = false;
    }
};

const cancel = () => {
    emit('cancel');
    dialog.value = false;
};
</script>