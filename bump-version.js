// bump-version.js
const fs = require('fs');
const path = require('path');
const semver = require('semver');

// Path to the VERSION file
const versionFilePath = path.join(__dirname, 'VERSION');

// Read the current version from the VERSION file
let currentVersion = fs.readFileSync(versionFilePath, 'utf8').trim();

// Get the bump type from the command-line arguments
const bumpType = process.argv[2]; // 'major', 'minor', or 'patch'

// Ensure the bump type is valid
if (!['major', 'minor', 'patch'].includes(bumpType)) {
  console.error("Usage: node bump-version.js <major|minor|patch>");
  process.exit(1);
}

// Calculate the new version
const newVersion = semver.inc(currentVersion, bumpType);

// Write the new version back to the VERSION file
fs.writeFileSync(versionFilePath, newVersion, 'utf8');

console.log(`Version bumped from ${currentVersion} to ${newVersion}`);
