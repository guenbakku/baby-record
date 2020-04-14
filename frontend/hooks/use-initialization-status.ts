import { ref, computed } from '@vue/composition-api'

export enum Statuses {
  Initializing = 0,
  Success,
  Error
}

const useInitializationStatus = () => {
  const initializationStatus = ref(Statuses.Initializing)

  const isInitializing = computed(
    () => initializationStatus.value === Statuses.Initializing
  )
  const isInitializationSuccess = computed(
    () => initializationStatus.value === Statuses.Success
  )
  const isInitializationError = computed(
    () => initializationStatus.value === Statuses.Error
  )

  const setInitializing = () => {
    initializationStatus.value = Statuses.Initializing
  }
  const setInitializationSuccess = () => {
    initializationStatus.value = Statuses.Success
  }
  const setInitializationError = () => {
    initializationStatus.value = Statuses.Error
  }

  return {
    isInitializing,
    isInitializationSuccess,
    isInitializationError,
    setInitializing,
    setInitializationSuccess,
    setInitializationError
  }
}

export default useInitializationStatus
