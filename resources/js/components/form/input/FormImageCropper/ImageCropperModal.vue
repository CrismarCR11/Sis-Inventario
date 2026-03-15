<template>
  <v-dialog v-model="internalDialog" max-width="800" persistent>
    <v-card>
      <v-card-title class="d-flex justify-space-between align-center">
        <span>{{ title }}</span>
        <v-btn icon @click.stop="closeDialog">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-title>

      <v-card-text>
        <div class="cropper-wrapper">
          <Cropper
            ref="cropper"
            :src="imageSrc"
            :stencil-props="{
              aspectRatio: aspectRatio,
            }"
            class="cropper"
            :transform-image="{
              adjustStencil: false
            }"
            @change="onCropperChange"
          />
        </div>
      </v-card-text>

      <v-card-actions class="pa-4">
        <v-btn color="secondary" @click="rotate(-90)" icon>
          <v-icon>mdi-rotate-left</v-icon>
        </v-btn>
        <v-btn color="secondary" @click="rotate(90)" icon>
          <v-icon>mdi-rotate-right</v-icon>
        </v-btn>
        <v-spacer />
        <v-btn color="error" @click="closeDialog">
          Cancelar
        </v-btn>
        <v-btn color="primary" @click="crop" :loading="loading">
          {{ confirmText }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

interface Props {
  dialog?: boolean;
  imageSrc?: string;
  title?: string;
  confirmText?: string;
  aspectRatio?: number;
  loading?: boolean;
  initialZoom?: number;
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Recortar imagen',
  confirmText: 'Guardar',
  aspectRatio: 1,
  loading: false,
  initialZoom: 1
});

const emit = defineEmits(['update:dialog', 'cropped', 'close']);

const internalDialog = computed({
  get: () => props.dialog,
  set: (value) => emit('update:dialog', value)
});

const cropper = ref<InstanceType<typeof Cropper>>();
const zoom = ref(props.initialZoom);

const onCropperChange = ({ zoom: currentZoom }: { zoom: number }) => {
  zoom.value = currentZoom;
};

const rotate = (degrees: number) => {
  cropper.value?.rotate(degrees);
};

const crop = () => {
  if (!cropper.value) return;
  
  const { canvas } = cropper.value.getResult();
  const base64 = canvas?.toDataURL('image/jpeg', 0.9);
  emit('cropped', base64);
  closeDialog();
};

const closeDialog = () => {
  emit('close');
  internalDialog.value = false;
};
</script>

<style scoped>
.cropper-wrapper {
  height: 60vh;
  min-height: 300px;
  max-height: 600px;
  background: #f5f5f5;
}

.cropper {
  height: 100%;
  width: 100%;
}

:deep(.vue-advanced-cropper__background) {
  background-color: #f5f5f5 !important;
}
</style>