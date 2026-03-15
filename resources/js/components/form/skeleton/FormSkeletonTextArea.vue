<template>
  <div class="skeleton-textarea-wrapper">
    <div class="skeleton-textarea" 
         :class="{
           'with-icon': icon,
           'has-error': hasError,
           'auto-grow': autoGrow
         }"
         :style="{ height: autoGrow ? 'auto' : `${rows * 24 + 32}px` }">
      <div v-if="icon" class="skeleton-prepend-icon"></div>
      <div class="skeleton-lines">
        <div v-for="i in rows" :key="i" class="skeleton-line"></div>
      </div>
    </div>
    <div v-if="hasError" class="skeleton-error-message"></div>
  </div>
</template>

<script setup lang="ts">
defineProps({
  label: { type: String, default: '' },
  icon: { type: String, default: '' },
  rows: { type: Number, default: 3 },
  autoGrow: { type: Boolean, default: false },
  hasError: { type: Boolean, default: false }
});
</script>

<style scoped>
.skeleton-textarea-wrapper {
  width: 100%;
}

.skeleton-label {
  height: 16px;
  width: 30%;
  margin-bottom: 4px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
  animation: skeleton-pulse 1.5s infinite ease-in-out;
}

.skeleton-textarea {
  position: relative;
  min-height: 56px;
  border: 1px solid rgba(0, 0, 0, 0.12);
  border-radius: 4px;
  padding: 16px 12px;
  background-color: white;
  animation: skeleton-pulse 1.5s infinite ease-in-out;
}

.skeleton-textarea.with-icon {
  padding-left: 40px;
}

.skeleton-textarea.has-error {
  border-color: #ff5252;
}

.skeleton-textarea.auto-grow {
  min-height: 104px; 
}

.skeleton-prepend-icon {
  position: absolute;
  left: 12px;
  top: 16px;
  width: 24px;
  height: 24px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 50%;
}

.skeleton-lines {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.skeleton-line {
  height: 16px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
}

.skeleton-line:last-child {
  width: 60%;
}

.skeleton-error-message {
  height: 16px;
  width: 60%;
  margin-top: 4px;
  background-color: rgba(255, 82, 82, 0.1);
  border-radius: 4px;
  animation: skeleton-pulse 1.5s infinite ease-in-out;
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