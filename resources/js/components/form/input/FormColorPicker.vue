<template>
  <div>
    <!-- Input que abre el diálogo -->
    <v-text-field
      :model-value="displayValue"
      :label="label"
      :name="name"
      :error-messages="errorMessage"
      variant="outlined"
      density="comfortable"
      readonly
      @click="dialog = true"
    >
      <template #prepend-inner>
        <v-icon :icon="icon" v-if="icon" />
      </template>
      <template #append>
        <div 
          class="color-preview" 
          :style="{ 
            backgroundColor: value || '#FFFFFF',
            borderColor: value ? 'transparent' : '#ddd'
          }"
        />
      </template>
    </v-text-field>

    <v-dialog v-model="dialog" max-width="450" scrollable>
      <v-card class="color-picker-dialog">
        <v-card-title class="d-flex justify-space-between align-center pa-4">
          <span class="text-h6">{{ label }}</span>
          <v-btn 
            icon 
            @click="dialog = false"
            variant="text"
            density="comfortable"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        
        <v-divider />
        
        <v-card-text class="pa-0">
          <div class="color-picker-container">
            <v-color-picker
              v-model="internalValue"
              :mode="mode"
              :modes="modes"
              :dot-size="dotSize"
              :swatches="swatches"
              :show-swatches="showSwatches"
              elevation="0"
              hide-inputs
              @update:modelValue="handleColorChange"
            />
          </div>
        </v-card-text>
        
        <v-divider />
        
        <v-card-actions class="pa-4">
          <v-spacer />
          <v-btn 
            color="primary" 
            variant="flat"
            @click="dialog = false"
          >
            Aceptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { useField } from 'vee-validate'

interface IFormColorPicker {
  name: string
  label?: string
  mode?: 'rgb' | 'rgba' | 'hsl' | 'hsla' | 'hex' | 'hexa'
  modes?: Array<'rgb' | 'rgba' | 'hsl' | 'hsla' | 'hex' | 'hexa'>
  dotSize?: number
  swatches?: string[][]
  showSwatches?: boolean
  icon?: string
}

const props = withDefaults(defineProps<IFormColorPicker>(), {
  label: '',
  mode: 'hex',
  modes: () => ['hex', 'rgb', 'rgba', 'hsl'] as Array<'hex' | 'rgb' | 'rgba' | 'hsl' | 'hsla' | 'hexa'>,
  dotSize: 12,
  swatches: () => [
    ['#FF0000', '#AA0000', '#550000'],
    ['#FFFF00', '#AAAA00', '#555500'],
    ['#00FF00', '#00AA00', '#005500'],
    ['#00FFFF', '#00AAAA', '#005555'],
    ['#0000FF', '#0000AA', '#000055'],
    ['#FF00FF', '#AA00AA', '#550055'],
    ['#000000', '#767676', '#FFFFFF']
  ],
  showSwatches: true,
  icon: 'mdi-palette'
})

const { value, errorMessage } = useField<string>(() => props.name)
const dialog = ref(false)
const internalValue = ref(value.value || '#FFFFFF')

const displayValue = computed(() => {
  return value.value || 'Seleccionar color'
})

const handleColorChange = (newColor: string) => {
  value.value = newColor
  emit('updated', newColor)
}

const emit = defineEmits<{
  (e: 'updated', payload: string): void
}>()

watch(value, (newVal) => {
  internalValue.value = newVal || '#FFFFFF'
})
</script>

<style scoped>
.color-preview {
  width: 28px;
  height: 28px;
  border: 1px solid;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.color-picker-dialog {
  overflow: hidden;
}

.color-picker-container {
  min-height: 350px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 8px;
}

/* Ajustes específicos para el color picker */
:deep(.v-color-picker) {
  width: 100% !important;
  max-width: 400px;
}

:deep(.v-color-picker__controls) {
  flex-direction: column;
}

:deep(.v-color-picker__canvas) {
  width: 100% !important;
  height: 200px !important;
}
</style>