<template>
  <Modal
    v-model="internalDialog"
    title=""
    :persistent="true"
    :max-width="props.maxWidth"
    @beforeClose="cancel"
  >
    <div class="d-flex flex-column gap-2 align-center">
       <v-icon
          v-if="icon"
          :icon="icon"
          size="64"
          :color="confirmButtonColor"
          class="mb-4"
        />
      <h3 class="text-center">{{ title }}</h3>
      <p class="text-center">{{ message }}</p>  
    </div>
    <v-card-actions class="d-flex justify-center">
      <v-spacer/>
      <v-btn color="primary" text @click="cancel">Cancelar</v-btn>
      <v-btn :color="confirmButtonColor" variant="flat"  @click="confirm">{{ confirmButtonText }} </v-btn>
    </v-card-actions>
  </Modal>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import Modal from '@/components/modal/Modal.vue';

interface Props {
  modelValue: boolean;
  title: string;
  message: string;
  confirmButtonText: string;
  confirmButtonColor: string;
  maxWidth?: string;
  icon?: string;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue', 'confirm']);

const internalDialog = ref(props.modelValue);

watch(() => props.modelValue, (newVal) => {
  internalDialog.value = newVal;
});

watch(internalDialog, (newVal) => {
  emit('update:modelValue', newVal);
});

const confirm = () => {
  emit('confirm');
  internalDialog.value = false;
}

const cancel = () => {
  internalDialog.value = false;
}
</script>