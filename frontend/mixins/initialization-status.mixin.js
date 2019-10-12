const STATUSES = {
  initializing: 0,
  success: 1,
  error: 2
}

export default {
  data() {
    return {
      initializationStatus: STATUSES.initializing
    }
  },
  computed: {
    isInitializing() {
      return this.initializationStatus === STATUSES.initializing
    },
    isInitializationSuccess() {
      return this.initializationStatus === STATUSES.success
    },
    isInitializationError() {
      return this.initializationStatus === STATUSES.error
    }
  },
  methods: {
    setInitializing() {
      this.initializationStatus = STATUSES.initializing
    },
    setInitializationSuccess() {
      this.initializationStatus = STATUSES.success
    },
    setInitializationError() {
      this.initializationStatus = STATUSES.error
    }
  }
}
