import moment from 'moment-timezone'

type Moment = typeof moment

const useDateTime = (moment: Moment) => {
  /**
   * Calculate age
   *
   * @param birthday - birthday string
   * @returns number array contains year, month, day
   */
  const calcAge = (birthday: string) => {
    const diffTime = moment().diff(birthday)
    const duration = moment.duration(diffTime)
    const age = [duration.years(), duration.months(), duration.days()]

    return age
  }

  return {
    calcAge
  }
}

export default useDateTime
