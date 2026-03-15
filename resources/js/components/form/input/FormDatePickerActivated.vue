<template>
  <div>
    <div class="date-label d-flex justify-center">
      <v-icon
        :icon="icon"
        :color="color"
        size="20"
        class="mr-2"
      ></v-icon>
      <span class="text-subtitle-1 font-weight-medium">
        {{ label }}
      </span>
    </div>
    <v-date-picker
      :id="id"
      :name="name"
      v-model="internalValue"
      :min="minDate"
      :max="maxDate"
      locale="es"
      width="100%"
      hide-header
      @update:modelValue="handleChange"
    ></v-date-picker>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps({
  modelValue: {
    type: String,
    default: null,
  },
  id: {
    type: String,
    required: true,
  },
  name: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  icon: {
    type: String,
    required: true,
  },
  color: {
    type: String,
    default: 'primary',
  },
  minDate: {
    type: String,
    default: null,
  },
  maxDate: {
    type: String,
    default: null,
  }
});

const emit = defineEmits(['update:modelValue']);

const internalValue = ref(props.modelValue);

watch(() => props.modelValue, (newVal) => {
  internalValue.value = newVal;
});

const handleChange = (newDate: string) => {
  internalValue.value = newDate;
  emit('update:modelValue', newDate);
};
</script>