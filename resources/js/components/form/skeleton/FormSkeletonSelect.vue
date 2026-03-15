<template>
  <div class="skeleton-select-wrapper">
    <div
      class="skeleton-select"
      :class="{
        'with-icon': icon,
        'is-multiple': multiple,
        'has-error': hasError,
      }"
    >
      <div v-if="icon" class="skeleton-prepend-icon"></div>
      <div class="skeleton-content">
        <div v-if="multiple" class="skeleton-chips">
          <div class="skeleton-chip" v-for="i in 5" :key="i"></div>
          <div class="skeleton-chip-placeholder"></div>
        </div>
        <div v-else class="skeleton-placeholder"></div>
      </div>
      <div class="skeleton-actions">
        <div class="skeleton-clear-icon" v-if="clearable"></div>
        <div class="skeleton-dropdown-icon"></div>
      </div>
    </div>
    <div v-if="hasError" class="skeleton-error-message"></div>
  </div>
</template>

<script setup lang="ts">
defineProps({
  label: { type: String, default: "" },
  icon: { type: String, default: "" },
  multiple: { type: Boolean, default: false },
  clearable: { type: Boolean, default: true },
  hasError: { type: Boolean, default: false },
});
</script>

<style scoped>
.skeleton-select-wrapper {
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

.skeleton-select {
  position: relative;
  height: 44px;
  border: 1px solid rgba(0, 0, 0, 0.12);
  border-radius: 4px;
  padding: 0 12px;
  margin: 0 0 22px 0;
  display: flex;
  align-items: center;
  background-color: white;
  animation: skeleton-pulse 1.5s infinite ease-in-out;
}

.skeleton-select.with-icon {
  padding-left: 40px;
}

.skeleton-select.is-multiple {
  height: auto;
  min-height: 44px;
  padding: 8px 12px;
  align-items: flex-start;
}

.skeleton-select.has-error {
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

.skeleton-content {
  flex-grow: 1;
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  align-items: center;
  min-height: 24px;
}

.skeleton-placeholder {
  width: 60%;
  height: 16px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
}

.skeleton-chips {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  align-items: center;
}

.skeleton-chip {
  height: 28px;
  width: 80px;
  background-color: rgba(0, 0, 0, 0.05);
  border-radius: 16px;
}

.skeleton-chip-placeholder {
  height: 24px;
  width: 40px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
}

.skeleton-actions {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-left: 8px;
}

.skeleton-clear-icon,
.skeleton-dropdown-icon {
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
