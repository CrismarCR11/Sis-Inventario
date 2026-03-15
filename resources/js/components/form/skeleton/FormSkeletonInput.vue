<template>
  <div class="skeleton-text-field-wrapper">
    <div
      class="skeleton-text-field"
      :class="{
        'with-icon': icon,
        'with-append-icon': hasAppendIcon,
        'has-error': hasError,
      }"
    >
      <div v-if="icon" class="skeleton-prepend-icon"></div>
      <div class="skeleton-input"></div>
      <div v-if="hasAppendIcon" class="skeleton-append-icon"></div>
    </div>
    <div v-if="hasError" class="skeleton-error-message"></div>
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = defineProps({
  label: { type: String, default: "" },
  icon: { type: String, default: "" },
  type: { type: String, default: "text" },
  hasError: { type: Boolean, default: false },
});

const hasAppendIcon = computed(() => props.type === "password");
</script>

<style scoped>
.skeleton-text-field-wrapper {
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

.skeleton-text-field {
  position: relative;
  height: 44px;
  border: 1px solid rgba(0, 0, 0, 0.12);
  border-radius: 4px;
  margin: 0 0 22px 0;
  padding: 0 12px;
  display: flex;
  align-items: center;
  background-color: white;
  animation: skeleton-pulse 1.5s infinite ease-in-out;
}

.skeleton-text-field.with-icon {
  padding-left: 40px;
}

.skeleton-text-field.with-append-icon {
  padding-right: 40px;
}

.skeleton-text-field.has-error {
  border-color: #ff5252;
}

.skeleton-prepend-icon {
  position: absolute;
  left: 12px;
  width: 24px;
  height: 24px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 50%;
}

.skeleton-input {
  flex-grow: 1;
  height: 24px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
}

.skeleton-append-icon {
  position: absolute;
  right: 12px;
  width: 24px;
  height: 24px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 50%;
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
  0%,
  100% {
    opacity: 0.6;
  }
  50% {
    opacity: 0.3;
  }
}
</style>
