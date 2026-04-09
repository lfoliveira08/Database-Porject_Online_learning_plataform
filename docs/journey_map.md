# User Journey Map — TechLearn Platform

## 1. Student Persona Journey

**Goal:** Create an account, browse available courses, enroll, and view metrics.

- **Phase 1: Discovery**
  - **Action:** User navigates to the Registration portal (`register_student.php`).
  - **Outcome:** The user's metadata is successfully saved to the `Students` SQL Table.
- **Phase 2: Action**
  - **Action:** User accesses the Enrollment portal (`enroll_student.php`).
  - **Outcome:** The system validates dropdown inputs against active IDs and binds them to the `Enrollments` schema.
- **Phase 3: Achievement**
  - **Action:** User takes courses externally, then receives assignment grades.
  - **Outcome:** Submissions securely stored inside the `Grades` database endpoint.

## 2. Instructor Persona Journey

**Goal:** Understand personal teaching metrics mapped against their specialized domains.

- **Phase 1: Analysis**
  - **Action:** Accesses `instructor_dashboard.php`.
  - **Outcome:** Instructor scans a centralized dashboard to observe overall capacity and throughput numbers dynamically calculated by aggregation JOIN functions.
- **Phase 2: Insights**
  - **Action:** Triggers the dropdowns on the dashboard.
  - **Outcome:** View explicitly how their courses are distributing over standard active, completed, or dropped variables.

## 3. Administrator Journey

**Goal:** Validate institutional momentum and financial stability.

- **Phase 1: High-level Tracking**
  - **Action:** Admin navigates to `reports.php`.
  - **Outcome:** Drops into the `Student Enrollment Summary` to oversee retention.
- **Phase 2: Fiscal Reporting**
  - **Action:** Admin clicks on `Course Revenue Report` and `Revenue by Category`.
  - **Outcome:** The pre-compiled database views seamlessly evaluate thousands of relational rows natively across PHP to produce zero-latency business tables.
