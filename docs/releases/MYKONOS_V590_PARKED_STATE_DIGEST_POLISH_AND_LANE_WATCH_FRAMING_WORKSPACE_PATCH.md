# Mykonos Loyalty Continuity v5.9.0

## Name
Parked-state digest polish and lane-watch framing workspace

## Type
Plugin-only major patch

## What changed
- added a new **Parked Finish State Digest** panel on live loyalty records
- added read-only parked-lane visibility for:
  - parked watch
  - reopen trigger
  - parked-state digest
  - parked-state visibility frame
- improved finish-lane follow-through readability with parked-watch and reopen-trigger framing
- loyalty list now shows:
  - Parked Watch
- linked inquiry loyalty snapshot now shows:
  - parked watch
  - reopen trigger
  - parked-state digest
- no theme changes
- no schema changes

## Why this patch exists
The loyalty line could already park finish lanes, but operators still had to reconstruct what a parked state meant from scattered finish fields. This patch makes parked referral, return-value, and reactivation lanes faster to read without widening into automation.

## Install
- extract from `/home/cabnet/public_html/`
- files land under `mykonos.cabnet.app/...`
- no `plugin:refresh` required
- clear backend cache if the new parked digest panel does not appear immediately
