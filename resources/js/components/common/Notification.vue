<template>
  <v-snackbar
    v-model="show"
    :color="type"
    :timeout="timeout"
    :location="location"
    :multi-line="true"
  >
    <div class="d-flex align-center">
      <v-icon :icon="icon" class="mr-3" size="24"></v-icon>
      <span>{{ message }}</span>
    </div>
    
    <template v-slot:actions>
      <v-btn variant="text" @click="show = false">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    message: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'info' // success, error, warning, info
    },
    timeout: {
        type: Number,
        default: 3000
    },
    location: {
        type: String,
        default: 'top'
    }
});

const emit = defineEmits(['update:modelValue']);

const show = ref(props.modelValue);

watch(() => props.modelValue, (val) => {
    show.value = val;
});

watch(show, (val) => {
    if (!val) {
        emit('update:modelValue', val);
    }
});

const icon = {
    success: 'mdi-check-circle',
    error: 'mdi-alert-circle',
    warning: 'mdi-alert',
    info: 'mdi-information'
}[props.type];
</script>