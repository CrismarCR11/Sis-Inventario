<template>
  <div>
    <!-- Preview de imagen cuando existe -->
    <div v-if="internalValue" class="image-preview-container">
      <v-img
        :src="internalValue"
        :aspect-ratio="aspectRatio"
        max-height="300"
        contain
        class="mb-4"
      ></v-img>
      
      <div class="d-flex justify-center">
        <v-btn color="primary" @click="dialog = true" class="mr-2">
          <v-icon left>mdi-crop</v-icon>
          Recortar
        </v-btn>
        <v-btn color="error" @click="removeImage">
          <v-icon left>mdi-delete</v-icon>
          Eliminar
        </v-btn>
      </div>
    </div>

    <!-- Input de archivo cuando no hay imagen -->
    <v-file-input
      v-else
      :label="label"
      :error-messages="errorMessage"
      accept="image/*"
      prepend-icon="mdi-camera"
      @update:modelValue="handleFileChange"
      :disabled="disabled"
      :clearable="clearable"
      :rules="rules"
    ></v-file-input>

    <ImageCropperModal
      v-model="dialog"
      :image-src="imagePreview || internalValue"
      :aspect-ratio="aspectRatio"
      :title="cropperTitle"
      :confirm-text="confirmText"
      :loading="loading"
      @cropped="handleCropped"
      @close="closeCropper"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useField } from 'vee-validate';
import ImageCropperModal from './ImageCropperModal.vue';

interface Props {
  name: string;
  label?: string;
  cropperTitle?: string;
  confirmText?: string;
  aspectRatio?: number;
  disabled?: boolean;
  clearable?: boolean;
  rules?: Array<(v: any) => string | boolean>;
}

const props = withDefaults(defineProps<Props>(), {
  label: 'Imagen',
  cropperTitle: 'Recortar imagen',
  confirmText: 'Guardar',
  aspectRatio: 1,
  disabled: false,
  clearable: true,
  rules: () => []
});

const { value: internalValue, errorMessage } = useField<string>(() => props.name);

const dialog = ref(false);
const imagePreview = ref('');
const loading = ref(false);

const handleFileChange = (files: File[] | File | null) => {
  if (!files) return;

  const file = Array.isArray(files) ? files[0] : files;
  
  if (!(file instanceof File)) return;

  const reader = new FileReader();
  reader.onload = (e) => {
    imagePreview.value = e.target?.result as string;
    dialog.value = true;
  };
  reader.onerror = () => console.error('Error al leer el archivo');
  reader.readAsDataURL(file);
}

const handleCropped = (base64: string) => {
  loading.value = true;
  internalValue.value = base64;
  loading.value = false;
  dialog.value = false;
  imagePreview.value = '';
}

const closeCropper = () => {
  dialog.value = false;
  imagePreview.value = '';
}

const removeImage = () => {
  internalValue.value = '';
}
</script>

<style scoped>
.image-preview-container {
  margin-bottom: 20px;
  text-align: center;
}
</style>