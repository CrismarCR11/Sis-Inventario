<template>
  <div class="skeleton-checkbox-wrapper">
    <div class="skeleton-checkbox" :class="{ 'has-error': hasError }">
      <!-- Checkbox square -->
      <div class="skeleton-checkbox-input"></div>
      
      <!-- Label -->
      <div class="skeleton-label"></div>
    </div>
    
    <!-- Error message -->
    <div v-if="hasError" class="skeleton-error-message"></div>
  </div>
</template>

<script setup lang="ts">
defineProps({
  label: {
    type: String,
    default: ""
  },
  hasError: {
    type: Boolean,
    default: false
  }
});
</script>

<style scoped>
.skeleton-checkbox-wrapper {
  display: flex;
  flex-direction: column;
  gap: 4px;
  height: 74px;
}

.skeleton-checkbox {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 15px 0;
}

.skeleton-checkbox-input {
  width: 18px;
  height: 18px;
  border: 2px solid rgba(0, 0, 0, 0.1);
  border-radius: 2px;
  animation: skeleton-pulse 1.5s infinite ease-in-out;
}

.skeleton-label {
  width: 120px;
  height: 16px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
  animation: skeleton-pulse 1.5s infinite ease-in-out;
}

.skeleton-error-message {
  height: 16px;
  width: 80%;
  margin-left: 30px; 
  background-color: rgba(255, 82, 82, 0.1);
  border-radius: 4px;
  animation: skeleton-pulse 1.5s infinite ease-in-out;
}

.skeleton-checkbox.has-error .skeleton-checkbox-input {
  border-color: rgba(255, 82, 82, 0.3);
}

@keyframes skeleton-pulse {
  0%, 100% {
    opacity: 0.6;
  }
  50% {
    opacity: 0.3;
  }
}
</style>