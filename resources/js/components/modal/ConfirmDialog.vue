<template>
  <Modal 
    v-model="internalVisible"
    :title="title" 
    :max-width="maxWidth" 
    :show-close="false"
  >
    <v-card-text class="d-flex align-start pa-4">
      <v-icon :color="color" size="36" class="mr-4 mt-1">{{ icon }}</v-icon>
      <div class="text-body-1 text-medium-emphasis">
        <slot>{{ message }}</slot>
      </div>
    </v-card-text>

    <v-card-actions class="px-5 pb-5 pt-0 d-flex justify-end gap-2">
      <v-btn 
        @click="cancel" 
        variant="outlined"
      >
        {{ cancelText }}
      </v-btn>
      <v-btn 
        @click="confirm" 
        :color="color" 
        variant="flat"
        :loading="loading"
      >
        {{ confirmText }}
      </v-btn>
    </v-card-actions>
  </Modal>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import Modal from './Modal.vue';

interface Props {
  modelValue: boolean;
  title: string;
  message?: string;
  maxWidth?: string | number;
  color?: 'error' | 'success' | 'warning' | 'primary';
  icon?: string;
  confirmText?: string;
  cancelText?: string;
  loading?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  message: '¿Está seguro de realizar esta acción?',
  maxWidth: '450px',
  color: 'error',
  icon: 'mdi-alert-circle-outline',
  confirmText: 'Aceptar',
  cancelText: 'Cancelar',
  title: '',
  loading: false,
});

const emit = defineEmits(['update:modelValue', 'confirm']);

const internalVisible = ref(props.modelValue);

watch(() => props.modelValue, (val) => {
  internalVisible.value = val;
});
watch(internalVisible, (val) => {
  emit('update:modelValue', val);
});

const close = () => {
  internalVisible.value = false;
};

const confirm = () => {
  emit('confirm');
};

const cancel = () => {
  close();
};

defineExpose({ close });
</script>